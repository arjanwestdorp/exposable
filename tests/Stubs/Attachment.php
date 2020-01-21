<?php

namespace ArjanWestdorp\Exposable\Test\Stubs;

use ArjanWestdorp\Exposable\Traits\Exposable;
use Illuminate\Database\Eloquent\Model;

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
