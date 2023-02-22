FROM node:18.14.1-alpine

WORKDIR /app

RUN apk update && apk upgrade
RUN apk add git
RUN apk add curl

COPY ./www/frontend/package*.json /app/

RUN npm install && npm cache clean --force

ENV PATH ./node_modules/.bin/:$PATH

COPY ./www/frontend/. .

RUN cp /app/.env.example /app/.env

RUN npm run build

WORKDIR /app

# CMD ["npm","run","preview"]
CMD [ "node" ,"--experimental-specifier-resolution=node" , ".output/server/index.mjs" ]
