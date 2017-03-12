<?php

/**
 * Clase para manejar los datos del usuario, tabla 'user'
 */
class User extends ActiveRecord {

    /**
     * Guarda un usuario y sube la foto de un usuario.
     * 
     * @param array $data Arreglo con los datos de usuario
     * @return boolean
     * @throws Exception
     */
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

    /**
     * Sube y actualiza la foto del usuario.
     * 
     * @return boolean | null
     */
    public function updatePhoto() {
        if ($photo = $this->uploadPhoto('photo')) {
            //Actualiza el campo photo
            $this->photo = $photo;
            return $this->update();
        }
    }

    /**
     * Sube la foto y retorna el nombre del archivo generado.
     * 
     * @param string $imageField
     * @return string|false
     */
    public function uploadPhoto($imageField) {
        //Usamos el adapter 'image'
        $file = Upload::factory($imageField, 'image');
        $fileName = false;
        //le asignamos las extensiones a permitir
        $file->setExtensions(array('jpg', 'png', 'gif'));
        //Intenta subir el arhivo
        if ($file->isUploaded()) {
            //Lo guarda usando un nombre de archivo aleatorio
            $fileName = $file->saveRandom();
        }
        
        return $fileName;
    }

}
