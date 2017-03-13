<?php

class UserController extends AppController {

    public function index($page = 1) {
        $this->data = (new User)->paginate("page: $page", 'order: id desc');
    }

    public function create() {
        if (Input::hasPost('user')) {
            $obj = new User;
            //En caso que falle la operación de guardar
            if (!$obj->saveWithPhoto(Input::post('user'))) {
                //se hacen persistente los datos en el formulario
                $this->data = Input::post('user');
                return;
            }

            Flash::valid('Usuario creado');
            return Redirect::to();
        }        
    }

    public function edit(int $id) {
        $this->user = (new User)->find((int) $id);
        //se verifica si se ha enviado via POST los datos
        if (Input::hasPost('user')) {
            //Intenta guardar los cambios
            if (!$this->user->update(Input::post('user'))) {
                //se hacen persistente los datos en el formulario
                $this->user = Input::post('user');
                return;
            } else {
                Flash::valid('Usuario actualizado');
                return Redirect::to();
            }
        }
    }

    public function update_photo(int $id) {
        $this->user = (new User)->find((int) $id);
        //se verifica si se ha enviado via POST los datos
        if (Input::hasPost('user')) {
            if (!$this->user->updatePhoto()) {
                //se hacen persistente los datos en el formulario
                $this->user = Input::post('user');
                return;
            } else {
                Flash::valid('Foto de usuario actualizada');
                return Redirect::to();
            }
        }
    }

}
