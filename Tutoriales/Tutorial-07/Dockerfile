FROM node:22-alpine
ENV NODE_ENV=production
WORKDIR /usr/src/app
COPY package*.json ./
RUN npm ci --omit=dev --no-audit --no-fund
COPY index.js ./
USER node
EXPOSE 80
CMD ["node", "index.js"]
