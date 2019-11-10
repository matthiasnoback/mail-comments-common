<?php

namespace MailCommentsCommon\Domain;

interface PostIdFactory
{
    public function nextPostId(): PostId;
}
