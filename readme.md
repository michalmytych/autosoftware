# Messages API + Vue SPA

### Setup:
```bash
# In root project directory:
docker-compose up --build
# After containers are built, in another shell session perform this command to enter php container:
docker-compose exec php bash
# Now, being in php container:
cd app && composer install
```
### Note!
Vue app may be up with slight delay, as it is building quite few modules:
```bash
[51%] building (908/1440 modules)
```