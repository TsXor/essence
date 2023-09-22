<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace TsXor\Essence\Listener;

use Flarum\Discussion\Discussion;
use TsXor\Essence\Event\DiscussionWasSetEssential;
use TsXor\Essence\Event\DiscussionWasUnsetEssential;
use TsXor\Essence\Post\DiscussionSetEssentialPost;
use Flarum\User\User;

class CreatePostWhenDiscussionIsSetEssential
{
    /**
     * @param DiscussionWasSetEssential $event
     */
    public static function whenDiscussionWasSetEssential(DiscussionWasSetEssential $event)
    {
        static::essentialChanged($event->discussion, $event->user, true);
    }

    /**
     * @param DiscussionWasUnsetEssential $event
     */
    public static function whenDiscussionWasUnsetEssential(DiscussionWasUnsetEssential $event)
    {
        static::essentialChanged($event->discussion, $event->user, false);
    }

    /**
     * @param Discussion $discussion
     * @param User $user
     * @param bool $isEssential
     */
    protected static function essentialChanged(Discussion $discussion, User $user, $isEssential)
    {
        $post = DiscussionSetEssentialPost::reply(
            $discussion->id,
            $user->id,
            $isEssential
        );

        $discussion->mergePost($post);
    }
}
