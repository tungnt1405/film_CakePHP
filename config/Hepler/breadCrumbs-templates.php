<?php
    return [
        'wrapper' => '<ul class="breadcumb"{{attrs}}>{{content}}</ul>',
        'item' => '<li{{attrs}}><a href="{{url}}"{{innerAttrs}}>{{title}}</a></li>{{separator}}',
        'itemWithoutLink' => '<li{{attrs}}><span{{innerAttrs}}></span>{{title}}</li>{{separator}}',
        'separator' => '<li{{attrs}}><span{{innerAttrs}}></span>{{separator}}</li>'
    ];