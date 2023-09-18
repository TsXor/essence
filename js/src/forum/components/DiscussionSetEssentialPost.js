import EventPost from 'flarum/forum/components/EventPost';

export default class DiscussionSetEssentialPost extends EventPost {
  icon() {
    return 'fas fa-star';
  }

  descriptionKey() {
    return this.attrs.post.content().essential
      ? 'flarum-essence.forum.post_stream.discussion_set_essential_text'
      : 'flarum-essence.forum.post_stream.discussion_unset_essential_text';
  }
}
