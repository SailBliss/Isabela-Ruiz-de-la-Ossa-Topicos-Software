# Tutorial 06 — Random Quotes con Express y Docker

Aplicación independiente que responde en `GET /` con una de las siete frases del enunciado. Se implementó con Node.js 24 y Express. La ruta final del contenedor escucha en el puerto 80; el modo local usa 3000 como en la primera etapa del tutorial.

## Requisitos

- Node.js 24 o superior y npm.
- Docker para construir y probar la imagen.

## Ejecución local

```bash
npm ci
npm start
```

Abra `http://localhost:3000/` y recargue para solicitar otra frase.

## Pruebas

```bash
npm test
```

Las pruebas comprueban las siete frases, los límites del selector aleatorio y la respuesta HTTP de la ruta raíz.

## Docker

El Dockerfile usa `node:24-alpine`, instala las dependencias desde el lockfile y configura `PORT=80`. El `EXPOSE 8080` se conserva como en el enunciado; `EXPOSE` es metadato y el puerto real del proceso es 80.

```bash
docker build -t randomquotes:1.0 .
docker run --rm -d --name randomquotes -p 8080:80 randomquotes:1.0
```

Abra `http://localhost:8080/`. Para detener la prueba local, ejecute `docker stop randomquotes`.

## Despliegue según el enunciado

Por instrucción de la estudiante, el proyecto permanece en el repositorio principal, en `Tutoriales/Tutorial-06`; no se creó otro repositorio ni otra instancia. Se desplegó en la EC2 existente del Tutorial 05, siguiendo el flujo Docker del curso. La introducción del PDF menciona GCP; se usó AWS porque la estudiante eligió explícitamente esa EC2.

La instancia ejecuta `randomquotes:1.0` como `tutorial06-randomquotes`, con reinicio automático y el puerto 80 del host publicado hacia el puerto 80 de Express. El grupo de seguridad permite SSH (22) únicamente desde la IP actual de la estudiante y HTTP (80) desde IPv4. No se abrió SSH a todo Internet. La dirección IPv4 actual es `54.209.251.48`; AWS puede cambiarla al detener e iniciar la instancia.

Para reproducir el despliegue, copie `Tutoriales/Tutorial-06` a la instancia, conéctese por SSH como `ec2-user` y ejecute:

```bash
cd randomquotes
docker build -t randomquotes:1.0 .
docker run -d --name tutorial06-randomquotes --restart unless-stopped -p 80:80 randomquotes:1.0
curl -i http://localhost/
```

El grupo de seguridad debe permitir TCP 80 para visitar `http://<IPv4-pública>/`. Para revisar o detener únicamente este servicio:

```bash
docker logs tutorial06-randomquotes
docker stop tutorial06-randomquotes
```

## Estado de entrega

Verificado con Node.js 24.7.0 (3/3 pruebas), Docker Desktop 4.97.0 (20 respuestas HTTP 200 locales y las siete frases) y en la EC2 existente (construcción de imagen, contenedor activo y 50 respuestas HTTP 200 públicas que devolvieron las siete frases). La transcripción de las comprobaciones remotas está en `evidencias/despliegue-ec2.txt`.
