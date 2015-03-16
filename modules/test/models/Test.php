<?php

namespace app\modules\test\models;

use app\components\ActiveRecord;


class Test extends ActiveRecord
{

    // param format
    // [{id: asd, type: fsdg, value: asdf}]
    // multiple
    // [{id: asd, type: fsdg, value: [asdf, sadf]}]
    // list
    // [{id: asd, type: fsdg, value: [asdf, sadf], values: id_list}]
    // dynamic
    // [{id: asd, type: fsdg, value: [asdf, sadf], source: asdfsdf}]

    public function rules()
    {
        return [];
    }

}