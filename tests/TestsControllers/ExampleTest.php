<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /*Se usa el siguiente Trait para que luego de ejecutar los Tests se realiza 
    *un callback en la BD , lo que significa que la elimina las tablas y la 
    *data ingresada, y realiza una migración  antes de la próxima prueba.
    *
    */
   use DatabaseMigrations;
    
     /**************************************************
      *             SHOW ALL EMPLOYEE
      **************************************************/

     /**
     * @test 
     * @author Luque Ayala Juan Alexis
     * @testdox A partir de esta notación indicaremos lo que se busca con la
     * siguiente funcion de test.La siguiente fucnión se realiza para mostrar todos los empleados
     * mediante una ruta de  nombre showAllEmployees
     * la respuesta debe ser un codigo HTTP_OK
     *  y un json con la estructura data para cada empleado y
     *  un code donde se muestra el código de la respuesta hhtp 
     */

    public function should_show_all_employees(){
        //ingresar resgitros de empleados
        factory('App\Models\Employee',3)->create();
        //comprobar codigo de respuesta
        $this->get(route('showAllEmployees'),[])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data' =>[
                '*' => [
                    'id',
                    'names',
                    'surname',
                    'email',
                    'address'
                ]
            ]
            ,
            'code'
        ]);

     }
     /**************************************************
      *             CREATE EMPLOYEE
      **************************************************/
      /**
     * @test 
     * @author Luque Ayala Juan Alexis
     * @testdox La siguiente función validará se usa para validar 
     * que el campa "names" sea un campo requerido para  poder 
     * ser guardado en la base de datos, se crea un objeto del modelo
     * Employee donde solo tiene el campo names como null
     * se realiza la peticion mediante un metodo post a la ruta de 
     * nombre 'createAnEmployee', se espera un respuesta HTTP_UNPROCESSABLE_ENTITY
     * y un Json con la estructura con los campos error y code, donde error muestra 
     * el error del campo requerido "names"
     */
    public function an_employee_requires_a_names_to_save(){
        //crear un objeto de la clase Employee, no se guarda en la base de datos
        $employee = factory('App\Models\Employee')->make(['names' => null]);
        //comprobar codigo de respuesta
        $this->post(route('createAnEmployee'),$employee->toArray(),[])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error'=>[
                'names'
            ],
            'code'
        ]);
    }
     
      
    /**
     * @test 
     * @author Luque Ayala Juan Alexis
     * @testdox La siguiente función validará se usa para validar 
     * que el campa "names" sea un campo 'unico' para  poder 
     * ser guardado en la base de datos, se crea un objeto del modelo
     * Employee y se guarda en la base de datos , luego 
     * se realiza la peticion mediante un metodo post a la ruta de 
     * nombre 'createAnEmployee',con el parametro del campo "names"
     * del objeto Employee ya guardado,se espera un respuesta HTTP_UNPROCESSABLE_ENTITY
     * y un Json con la estructura con los campos error y code, donde error muestra 
     * el error del campo requerido "names"
     */
    public function an_employee_has_a_unique_names_to_save(){
        //ingresar un resgitro de empleado
        $employee = factory('App\Models\Employee')->create();
        //comprobar codigo de respuesta
        $this->post(route('createAnEmployee'),['names'=>$employee->names],[])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error'=>[
                'names'
            ],
            'code'
        ]);

       
        
     }


      /**
     * @test 
     * @author Luque Ayala Juan Alexis
     * @testdox La siguiente función validará se usa para validar 
     * que el campa "surname" sea un campo requerido para  poder 
     * ser guardado en la base de datos, se crea un objeto del modelo
     * Employee donde solo tiene el campo names como null
     * se realiza la peticion mediante un metodo post a la ruta de 
     * nombre 'createAnEmployee', se espera un respuesta HTTP_UNPROCESSABLE_ENTITY
     * y un Json con la estructura con los campos error y code, donde error muestra 
     * el error del campo requerido "surname"
     */
    public function an_employee_requires_a_surname_to_save(){
        //creando un objeto del modelo Employee, solo con el campo surname
        $employee = factory('App\Models\Employee')->make(['surname' => null]);
        //comprobar codigo de respuesta
        $this->post(route('createAnEmployee'),$employee->toArray(),[])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error'=>[
                'surname'
            ],
            'code'
        ]);
    }

     /**
     * @test 
     * @author Luque Ayala Juan Alexis
     * @testdox La siguiente función validará se usa para validar 
     * que el campa "surname" sea un campo 'unico' para  poder 
     * ser guardado en la base de datos, se crea un objeto del modelo
     * Employee y se guarda en la base de datos , luego 
     * se realiza la peticion mediante un metodo post a la ruta de 
     * nombre 'createAnEmployee',con el parametro del campo "names"
     * del objeto Employee ya guardado,se espera un respuesta HTTP_UNPROCESSABLE_ENTITY
     * y un Json con la estructura con los campos error y code, donde error muestra 
     * el error del campo requerido "names"
     */
    public function an_employee_has_a_unique_surname_to_save(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();
        //comprobar codigo de respuesta
        $this->post(route('createAnEmployee'),['names'=>$employee->surname],[])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'error'=>[
                'surname'
            ],
            'code'
        ]);

       
        
     }


     /**
     * @test
     * @depends an_employee_requires_a_names_to_save
     * @depends an_employee_requires_a_surname_to_save
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para crear un empleado
     * mediante la route de  nombre createAnEmployee
     * la respuesta debe ser un codigo HTTP_CREATED
     *  y un json con la estructura data y un code
     */
    public function should_create_an_employee(){
        //crear un objeto de la clase Employee que no es insertado en la BD
        $employee = factory('App\Models\Employee')->make();
        //comprobar codigo de respuesta
        $this->post(route('createAnEmployee'),$employee->toArray(),[])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code'
        ]);
        //Vverificamos que se haya alamcenado en la BD
        $this->seeInDatabase('employees', $employee->toArray());


     }
     /**************************************************
      *             GET AN EMPLOYEE
      **************************************************/
     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox  El siguiente test se usa para obtener un empleado
     * mediante una petitición de tipo get a la 
     * la route de  nombre showAnEmployee
     * la respuesta debe ser un codigo HTTP_OK
     *  y un json con la estructura data y un code
     */
    public function should_get_an_employee(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();;
        //comprobar codigo de respuesta
        $this->get(route('showAnEmployee',['id' => $employee->id]))
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code'
        ]);

        

     }

         /**************************************************
      *             UPDATE AN EMPLOYEE
      **************************************************/
     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para actualizar la 
     * información de un empleado
     * mediante una petitición de tipo put a la 
     * ruta de  nombre updateAnEmployee
     * la respuesta debe ser un codigo HTTP_CREATED
     */
    public function should_update_an_employee(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();
        //la data que será enviada para actualizar los datos del empleado
        $data = [
            'names' => 'a',
            'surname' => 'b'
        ];
        //comprobar codigo de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,[])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code'
        ]);

     }

      /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox  El siguiente test se usa para vlidar que se debe 
     * realizar cambios en la nueva información para hacer la actualización
     * de la información mediante mediante una petitición de tipo put a la 
     *  la ruta de  nombre updateAnEmployee
     * la respuesta debe ser un codigo http 201
     *  y un json con la estructura data y un code
     */
    public function should_changes_values_to_update_an_employee(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();
        //data para actualizar
        $data = [
            'names' => $employee->names,
            'surname' => $employee->surname,
        ];
        //comprobar codigo de respuesta
        $this->put(route('updateAnEmployee',['id' => $employee->id]),$data,[])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comporbar structura de la resputa y contenido de la misma
        $this->seeJsonEquals([
            'error' => 'At least one value must change',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY
        ]);

     }

     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para actualizar la 
     * información de un empleado
     * mediante la petitición de tipo patch se le envia a la 
     * ruta de  nombre updateAnEmployee
     * la respuesta debe ser un codigo HTTP_CREATED
     */
    public function should_update_an_employee_patch(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();
        //data a cambiar
        $data = [
            'names' => 'a',
            'surname' => 'b'
        ];
        //comprobar codigo de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,[])
        ->assertResponseStatus(Response::HTTP_CREATED);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code'
        ]);
        
        

     }

       /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox  El siguiente test se usa para vlidar que se debe 
     * realizar cambios en la nueva información para hacer la actualización
     * de la información mediante la petitición de tipo patch se le envia a la 
     * ruta de  nombre updateAnEmployee
     * la respuesta debe ser un codigo HTTP_CREATED
     */
    public function should_changes_values_to_update_an_employee_patch(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();
        //data que será enviada
        $data = [
            'names' => $employee->names,
            'surname' => $employee->surname,
        ];
        //comprobar codigo de respuesta
        $this->patch(route('updateAnEmployee',['id' => $employee->id]),$data,[])
        ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        //comprobar estructura de respuesta
        $this->seeJsonEquals([
            'error' => 'At least one value must change',
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY
        ]);

     }
     /**************************************************
      *             DELETE EMPLOYEE
      **************************************************/
     /**
     * @test
     * @author Luque Ayala Juan Alexis
     * @testdox El siguiente test se usa para crear un empleado
     * mediante la route de  nombre createAnEmployee
     * la respuesta debe ser un codigo http 201
     *  y un json con la estructura data y un code
     */
    public function should_delete_an_employee(){
        //ingresar resgitros de empleados
        $employee = factory('App\Models\Employee')->create();

        $this->seeInDatabase('employees', $employee->toArray());
        
        //comprobar codigo de respuesta
        $this->delete(route('deleteAnEmployee',['id' => $employee->id]),[])
        ->assertResponseStatus(Response::HTTP_OK);
        //comprobar estructura de respuesta
        $this->seeJsonStructure([
            'data',
            'code'
        ]);

        //validando que no se encuentre registrado en la base de datos
        $this->notSeeInDatabase('employees', $employee->toArray());

     }
     
}
