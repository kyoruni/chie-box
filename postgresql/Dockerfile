FROM postgres:17.4

ENV POSTGRES_USER=postgres
ENV POSTGRES_PASSWORD=secret
ENV POSTGRES_DB=chiebox

COPY postgresql/init.sql /docker-entrypoint-initdb.d/

CMD ["postgres"]