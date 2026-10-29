# Tutorial 07 — Random Quotes en ECS/Fargate

Microservicio Express con Docker, publicado en Amazon ECR y ejecutado como cuatro tareas Fargate detrás de un Application Load Balancer (ALB). El endpoint `/` devuelve una frase y el hostname del contenedor; `/health` sirve para comprobar el proceso. El target group sigue el enunciado y comprueba `/`.

## Requisitos

- Node.js 22 o posterior y npm.
- Docker para la prueba local y la construcción de la imagen.
- AWS CLI autenticada en una sola región (por defecto `us-east-1`), con permisos para ECR, ECS, IAM PassRole, VPC, ELB y CloudWatch.
- Una VPC con dos subredes públicas en zonas distintas. El modo de práctica asigna IP pública a las tareas Fargate.
- Un rol de ejecución de tareas de ECS con confianza `ecs-tasks.amazonaws.com` y permisos `AmazonECSTaskExecutionRolePolicy`. En AWS Academy, la guía de laboratorio puede proporcionar `LabRole`; confirmar que la cuenta permite pasarlo a ECS.
- Un rol IAM para GitHub Actions con proveedor OIDC `token.actions.githubusercontent.com`, confianza limitada a este repositorio y a `main`, y permisos mínimos de push a ECR y actualización/lectura del servicio ECS.

**AWS Academy:** la cuenta Learner Lab puede impedir crear proveedores/roles IAM personalizados. Si no existe un rol OIDC que el laboratorio permita usar, el workflow no podrá autenticarse desde GitHub Actions; no se usan claves IAM permanentes como alternativa. En ese caso se requiere un rol habilitado por el curso o una cuenta AWS con permisos compatibles.

## Ejecutar y probar localmente

```bash
npm ci
npm test
npm start
```

La app escucha en el puerto 80 por defecto (`PORT` permite cambiarlo). Abra `http://localhost:80/` y repita la solicitud para observar frases aleatorias.

Prueba en contenedor:

```bash
docker build -t randomquotes:local .
docker run --rm -p 8080:80 randomquotes:local
```

Abra `http://localhost:8080/`. Esta prueba local no crea recursos AWS.

## Despliegue en AWS

> **Costos:** cuatro tareas de 0.25 vCPU/0.5 GB, un ALB y las direcciones IPv4 públicas pueden generar cargos mientras existan. Con los precios públicos consultados para `us-east-1`, el cálculo ilustrativo mínimo es aproximadamente **USD 0.102/hora (USD 2.44/día o USD 73.35 por 30 días)** antes de consumo LCU del ALB, transferencia, logs, impuestos y posibles diferencias de tarifas. Considerando 1 LCU/hora, sería aproximadamente **USD 0.110/hora (USD 2.64/día o USD 79.11 por 30 días)**. ECR y CloudWatch dependen del almacenamiento y volumen. No despliegue sin revisar el presupuesto disponible. Detenga y elimine los recursos exclusivos al terminar; detener la EC2 del Tutorial 05/06 no elimina este servicio.

El despliegue está dividido para que la primera imagen exista antes de registrar la definición ECS:

1. Autentique AWS CLI y compruebe región/cuenta con `aws sts get-caller-identity` y `aws configure get region`. No guarde credenciales en archivos versionados.
2. Cree ECR desde `infra/ecr.yml`:

   ```bash
   aws cloudformation deploy --stack-name tutorial-07-ecr --template-file infra/ecr.yml
   ```

3. Construya, autentique y publique la imagen inicial. Sustituya `ACCOUNT_ID` por el ID devuelto por STS; la cuenta/región deben ser las mismas que ECS:

   ```bash
   ACCOUNT_ID="$(aws sts get-caller-identity --query Account --output text)"
   REGION="us-east-1"
   REGISTRY="$ACCOUNT_ID.dkr.ecr.$REGION.amazonaws.com"
   aws ecr get-login-password --region "$REGION" | docker login --username AWS --password-stdin "$REGISTRY"
   docker build -t randomquotes:latest .
   docker tag randomquotes:latest "$REGISTRY/randomquotes:latest"
   docker push "$REGISTRY/randomquotes:latest"
   ```

4. Obtenga VPC ID, dos subredes públicas en zonas diferentes y ARN del rol de ejecución de tareas. Revise permisos de IAM antes de crear recursos. Despliegue `infra/ecs.yml` pasando esos valores y la URI ECR:

   ```bash
   aws cloudformation deploy \
     --stack-name tutorial-07-ecs \
     --template-file infra/ecs.yml \
     --parameter-overrides \
       VpcId=vpc-REEMPLAZAR \
       PublicSubnetA=subnet-REEMPLAZAR \
       PublicSubnetB=subnet-REEMPLAZAR \
       EcrImageUri="$REGISTRY/randomquotes:latest" \
       EcsExecutionRoleArn=arn:aws:iam::ACCOUNT_ID:role/REEMPLAZAR
   ```

   No copie identificadores de ejemplos ni de otras cuentas. Sustituya también `ACCOUNT_ID` por el ID obtenido con STS. Si AWS Academy no permite pasar `LabRole` o crear el rol OIDC, la consola/CloudFormation rechazará el despliegue; no reduzca las reglas de seguridad ni use credenciales permanentes para evadirlo.

5. Confirme que ECS muestra cuatro tareas `RUNNING`, target group cuatro destinos `healthy`, y pruebe la salida `ApplicationUrl` de la pila varias veces. La respuesta incluye hostname, que permite observar las tareas atendiendo solicitudes. Detenga una tarea desde ECS y espere su reemplazo automático por el servicio.
6. En la configuración GitHub del repositorio, añada `AWS_ROLE_ARN` como Actions secret con el ARN del rol OIDC. El workflow en `../../.github/workflows/tutorial-07-deploy.yml` espera `main`, prueba, construye y sube la imagen (tag `latest` y SHA), y fuerza un nuevo despliegue ECS. El rol debe confiar solo en `repo:SailBliss/Isabela-Ruiz-de-la-Ossa-Topicos-Software:ref:refs/heads/main` y permitir ECR push y las operaciones ECS necesarias. El workflow solo corre cuando cambian los archivos de este tutorial o el propio workflow.

Referencias oficiales de precios y OIDC: [Fargate](https://aws.amazon.com/fargate/pricing/), [Application Load Balancer](https://aws.amazon.com/elasticloadbalancing/pricing/), [IPv4 pública](https://aws.amazon.com/vpc/pricing/) y [GitHub OIDC en AWS](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_roles_providers_create_oidc.html).

### Evidencias de entrega

Guardar capturas reales en `evidencias/` (no se incluyen capturas no generadas):

1. ECS Service con cuatro tareas `RUNNING`.
2. Target group con destinos `healthy`.
3. URL del ALB mostrando la frase y hostname; varias solicitudes que demuestren al menos tres hostnames si el reparto lo permite.
4. Evento de ECS donde se detuvo una tarea y el servicio volvió a cuatro tareas.
5. GitHub Actions con un run exitoso y el servicio actualizado.

Registrar también la explicación del papel del ALB, la recuperación automática y cualquier límite de distribución observado. No incluir datos de acceso ni secretos.

### Limpieza

Cuando termine la evidencia, elimine primero el servicio/stack `tutorial-07-ecs` y confirme que las tareas se detuvieron; después elimine `tutorial-07-ecr` si ya no necesita la imagen. Revise en CloudFormation que ambas pilas se eliminaron y en Billing/Cost Explorer que no queden cargos asociados. No borre recursos compartidos o existentes de otros tutoriales.

## Validación local registrada

La auditoría local validó las pruebas Node y el build/arranque de Docker. El resumen reproducible está en `evidencias/validacion-local.txt`. La creación de recursos AWS, el ALB, las cuatro tareas, el failover y GitHub Actions **no están verificados** hasta que se autorice y ejecute el despliegue en la cuenta propia.
