# Use the official Nginx image as the base
FROM nginx:alpine

# Copy the content of /var/www/html from the host machine to the container
COPY ./html /usr/share/nginx/html

# Expose port 80 to allow external access
EXPOSE 80

# Start Nginx in the foreground
CMD ["nginx", "-g", "daemon off;"]

