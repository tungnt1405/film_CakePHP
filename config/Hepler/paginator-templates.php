<?php
    return [
        'number' => '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
        'current' => '<li class="page-item active"><a href="{{url}}" class="page-link">{{text}}</a></li>',
        'first' => '<li class="page-item"><a class="page-link" href="{{url}}">&laquo;</a></li>',
        'last' => '<li class="page-item"><a class="page-link" href="{{url}}">&raquo;</a></li>',
        'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">&lt;</a></li>',
        'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">&gt;</a></li>',
        'nextDisabled' => '<li class="page-item"></li>'
    ];