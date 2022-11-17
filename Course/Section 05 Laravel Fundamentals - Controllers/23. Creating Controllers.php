<?php

# controllers are middleman between a route & view
# they are responsible for fetch data from database and then sending it to view
# or take data from view & then store it in the database
# they are located in `app` > `Http` > `Controllers`

# you can create a controller by two methods
# first one by just creating a php file manually in `Controller` folder
# second method by typing following command in terminal
# $ php artisan make:controller ControllerName

# Also you can create a controller with build in function signtures using follwoing command
# $ php artisan make:controller --resource ControllerName
# just add [--resource] flag

