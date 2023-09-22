<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace TsXor\Essence\Post;

use Carbon\Carbon;
use Flarum\Post\AbstractEventPost;
use Flarum\Post\MergeableInterface;
use Flarum\Post\Post;

class DiscussionSetEssentialPost extends AbstractEventPost implements MergeableInterface
{
    /**
     * {@inheritdoc}
     */
    public static $type = 'discussionSetEssential';

    /**
     * {@inheritdoc}
     */
    public function saveAfter(Post $previous = null): static
    {
        // If the previous post is another 'discussion stickied' post, and it's
        // by the same user, then we can merge this post into it. If we find
        // that we've in fact reverted the sticky status, delete it. Otherwise,
        // update its content.
        if ($previous instanceof static && $this->user_id === $previous->user_id) {
            if ($previous->content['essential'] != $this->content['essential']) {
                $previous->delete();
            } else {
                $previous->content = $this->content;

                $previous->save();
            }

            return $previous;
        }

        $this->save();

        return $this;
    }

    /**
     * Create a new instance in reply to a discussion.
     *
     * @param int $discussionId
     * @param int $userId
     * @param bool $isEssential
     * @return static
     */
    public static function reply($discussionId, $userId, $isEssential)
    {
        $post = new static;

        $post->content = static::buildContent($isEssential);
        $post->created_at = Carbon::now();
        $post->discussion_id = $discussionId;
        $post->user_id = $userId;

        return $post;
    }

    /**
     * Build the content attribute.
     *
     * @param bool $isEssential Whether or not the discussion is stickied.
     * @return array
     */
    public static function buildContent($isEssential)
    {
        return ['essential' => (bool) $isEssential];
    }
}
