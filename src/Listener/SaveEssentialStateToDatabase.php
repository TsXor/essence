<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Essence\Listener;

use Flarum\Discussion\Event\Saving;
use Flarum\Essence\Event\DiscussionWasSetEssential;
use Flarum\Essence\Event\DiscussionWasUnsetEssential;

class SaveEssentialStateToDatabase
{
    /**
     * @param Saving $event
     */
    public function handle(Saving $event)
    {
        if (isset($event->data['attributes']['isEssential'])) {
            $isEssential = (bool) $event->data['attributes']['isEssential'];
            $discussion = $event->discussion;
            $actor = $event->actor;

            $actor->assertCan('set_essential', $discussion);

            if ((bool) $discussion->is_essential === $isEssential) {
                return;
            }

            $discussion->is_essential = $isEssential;

            $discussion->raise(
                $discussion->is_essential
                    ? new DiscussionWasSetEssential($discussion, $actor)
                    : new DiscussionWasUnsetEssential($discussion, $actor)
            );
        }
    }
}
