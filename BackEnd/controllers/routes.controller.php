<?php

class RoutesController{

    public function startRoutes(){

        // De esta forma se ejecuta un .php dentro de otro .php
        include "routes/routes.php";
    }
}