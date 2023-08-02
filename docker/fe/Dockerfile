FROM node:18-alpine AS builder

ENV NODE_OPTIONS=--max_old_space_size=2048

WORKDIR /app

COPY ./frontend /app

RUN yarn install \
  && yarn build

FROM nginx:1.23.3

COPY ./docker/fe/default.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/dist/ /usr/share/nginx/html

# Expose the port for access
EXPOSE 80/tcp

# Run the Nginx server
CMD ["/usr/sbin/nginx", "-g", "daemon off;"]