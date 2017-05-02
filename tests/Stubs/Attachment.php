<?php

namespace ArjanWestdorp\Exposable\Test\Stubs;

use Illuminate\Database\Eloquent\Model;
use ArjanWestdorp\Exposable\Traits\Exposable;

class Attachment extends Model
{
    use Exposable;

    /**
     * Expose the model.
     *
     * @return \Illuminate\Http\Response
     */
    public function expose()
    {
        return response('You did it');
    }
}
