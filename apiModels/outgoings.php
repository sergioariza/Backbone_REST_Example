<?php

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Model\Message,
    Phalcon\Mvc\Model\Validator\InclusionIn,
    Phalcon\Mvc\Model\Validator\Uniqueness;

class outgoings extends Model
{

    public function validation()
    {
        $this->validate(new Uniqueness(
            array(
                "field"   => "id",
                "message" => "The outgoing id must be unique"
            )
        ));

        //Year cannot be less than zero
        if ($this->quantity < 0) {
            $this->appendMessage(new Message("The outgoing quantity cannot be less than zero"));
        }

        //Check if any messages have been produced
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}