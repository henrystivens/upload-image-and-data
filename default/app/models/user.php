<?php

/**
 * 
 */
class User extends ActiveRecord {

    public function saveWithPhoto($data) {
        //Inicia la transacción
        $this->begin();
        if ($this->create($data)) {
            if ($photo = $this->uploadPhoto('photo')) {
                //Actualiza el campo foto
                $this->photo = $photo;
                if ($this->update()) {
                    $this->commit();
                    return true;
                } else {
                    $this->rollback();
                    return false;
                }
            } else {
                $this->rollback();
                throw new Exception('No se pudo subir la imagen');
            }
        } else {
            $this->rollback();
            return false;
        }
    }

    public function updatePhoto() {
        if ($photo = $this->uploadPhoto('photo')) {
            //Actualiza el campo foto
            $this->photo = $photo;
            if ($this->update()) {
                return true;
            } else {

                return false;
            }
        }
    }

    public function uploadPhoto($image_field) {
        $file = Upload::factory($image_field, 'image');
        //le asignamos las extensiones a permitir
        $file->setExtensions(array('jpg', 'png', 'gif'));
        if ($file->isUploaded()) {
            if ($file_name = $file->saveRandom()) {
                return $file_name;
            }
        } else {
            return false;
        }
    }

}
