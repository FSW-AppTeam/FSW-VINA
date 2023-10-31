FROM node:20-alpine

# entrypoint
COPY ./docker/frontend-entrypoint.sh /frontend-entrypoint.sh
RUN chmod ugo+x /frontend-entrypoint.sh
RUN dos2unix /frontend-entrypoint.sh

ENTRYPOINT /frontend-entrypoint.sh
