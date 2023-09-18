<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Essence\Listener;

use Flarum\Discussion\Discussion;
use Flarum\Essence\Event\DiscussionWasSetEssential;
use Flarum\Essence\Event\DiscussionWasUnsetEssential;
use Flarum\Essence\Post\DiscussionSetEssentialPost;
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
