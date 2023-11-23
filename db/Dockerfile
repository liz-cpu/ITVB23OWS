# Use the official MySQL image as a parent image
FROM mysql:8.2

# Set the MySQL root password
ENV MYSQL_ROOT_PASSWORD=passw
ENV MYSQL_DATABASE=hive
ENV MYSQL_USER=hiveuser
ENV MYSQL_PASSWORD=hivepassword

# Copy the database initialization script into the container
COPY init.sql /docker-entrypoint-initdb.d/