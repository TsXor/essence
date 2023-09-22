import Extend from 'flarum/common/extenders';
import Model from 'flarum/common/Model';
import Discussion from 'flarum/common/models/Discussion';
import DiscussionSetEssentialPost from './components/DiscussionSetEssentialPost';

export default [
  new Extend.PostTypes() //
    .add('discussionSetEssential', DiscussionSetEssentialPost),

  new Extend.Model(Discussion) //
    .attribute<boolean>('isEssential')
    .attribute<Date, string>('lastSetEssentialAt', Model.transformDate)
    .attribute<boolean>('canSetEssential'),
];
