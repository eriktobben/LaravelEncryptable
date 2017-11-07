<?php


namespace Cheezykins\LaravelEncryptable\Traits;


use Illuminate\Support\Facades\Crypt;

trait Encryptable
{

    /**
     * Decrypt the column value if it is in the encrypted array.
     *
     * @param $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encrypted ?? [])) {
            $value = Crypt::decrypt($value);
        }
        return $value;
    }

    /**
     * Set the value, encrypting it if it is in the encrypted array.
     *
     * @param $key
     *
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypted ?? [])) {
            $value = Crypt::encrypt($value);
        }
        return parent::setAttribute($key, $value);
    }

    /**
     * Retrieves all values and decrypts them if needed.
     *
     * @return mixed
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->encrypted ?? [] as $key) {
            if (isset($attributes[$key])) {
                $attributes[$key] = Crypt::decrypt($attributes[$key]);
            }
        }

        return $attributes;
    }
}