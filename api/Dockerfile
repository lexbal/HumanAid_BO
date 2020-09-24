FROM node:14

WORKDIR /app

COPY package*.json ./

RUN npm install npm -g
RUN npm install

COPY . .

EXPOSE 8081
CMD ["yarn", "start"]
