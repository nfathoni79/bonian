<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $branches
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">


    <div class="m-content">
        <div class="row">
            <div class="col-lg-4">
                <!--begin:: Widgets/Authors Profit-->
                <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption" style="width: 100%; margin-top: 18px;">
                            <div class="m-input-icon m-input-icon--left">
                                <input type="text" class="form-control m-input m-input--solid" placeholder="Email">
                                <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="flaticon-search"></i></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-widget4 m-scrollable m-scrollable--track nav chat-discussions" data-scrollable="true" role="tablist">
                        </div>
                    </div>
                </div>

                <!--end:: Widgets/Authors Profit-->
            </div>

            <div class="col-lg-8">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-time"></i>
												</span>
                                <h3 class="m-portlet__head-text chat-head-title">

                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <?php /*<ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-cloud-upload"></i></a>
                                </li>
                                <li class="m-portlet__nav-item">
                                    <a href="" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-cog"></i></a>
                                </li>
                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                    <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-dropdown__toggle">
                                        <i class="la la-ellipsis-h"></i>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__section m-nav__section--first">
                                                            <span class="m-nav__section-text">Quick Actions</span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                <span class="m-nav__link-text">Activity</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                <span class="m-nav__link-text">Messages</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                                <span class="m-nav__link-text">FAQ</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                <span class="m-nav__link-text">Support</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit">
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Cancel</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <?php */ ?>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">

                            <div class="tab-content">
                            </div>


                            <div class="m-messenger__seperator">
                                <span class="typing">&nbsp;</span>
                            </div>
                            <div class="m-messenger__form">
                                <div class="m-messenger__form-controls">
                                    <input type="text" name="" placeholder="Type here..." class="m-messenger__form-input form-control">
                                </div>
                                <div class="m-messenger__form-tools">
                                    <a href="" class="m-messenger__form-attachment">
                                        <i class="la la-paperclip"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--end::Portlet-->
            </div>

        </div>
    </div>
</div>

<?php
$this->Html->script([
    '/admin-assets/app/js/tinysort.js',
    '/admin-assets/app/js/jquery.tinysort.js',
], ['block' => true]);
?>

<?php $this->append('script'); ?>
<script>
    const user_id = '<?= $this->request->getSession()->read('Auth.Users.username'); ?>';
    const csrfToken = '<?= $this->request->getParam('_csrfToken'); ?>';
    const instance_locator = '<?= \Cake\Core\Configure::read('ChatKit.instance_locator'); ?>';
    var isInitial = false;
    var currentUser;
    $(document).ready(function() {
        const tokenProvider = new Chatkit.TokenProvider({
            url: '<?= $this->Url->build(['action' => 'authorize']); ?>',
            queryParams: {
                type: 'chatkit'
            },
            headers: {
                'X-CSRF-Token': csrfToken,
                'x-requested-with': 'XMLHttpRequest'
            }
        });

        const noopLogger = (...items) => {}

        $(document).on('click', '.chat-discussions .room', function () {
            var lastMessageId = $(this).data('last-message-id');
            var roomId = $(this).data('room-id');
            var self = this;

            if ($(this).data('unread-count') > 0) {
                currentUser.setReadCursor({
                    roomId: String($(this).data('room-id')),
                    position: lastMessageId
                })
                    .then(() => {
                        //console.log('Success!')
                        $(self).attr('data-unread-count', 0)
                            .find('.m-badge')
                            .addClass('hidden')
                            .text('0');
                    })
                    .catch(err => {
                        //console.log(`Error setting cursor: ${err}`)
                    });
            }

            var typing = $('.typing').attr('id', `typing-${roomId}`);
            $('.chat-head-title').text($(this).find('.m-widget4__title').text());

            var scroll = $('#room-' + roomId);
            var height = 0;
            scroll.find('.m-messenger__wrapper').each(function() {
                height += $(this).height();
            });
            scroll.find('.m-messenger__messages').scrollTop(height);





        });



        $(".m-messenger__form-input").on('keyup', function (e) {

            var roomId = String($('.m-messenger .tab-pane.active').data('room-id'));
            currentUser.isTypingIn({ roomId: roomId })
                .then(() => {
                    //console.log('Success!')
                })
                .catch(err => {
                    //console.log(`Error sending typing indicator: ${err}`)
                });


            if (e.keyCode == 13) {
                var roomId = String($('.m-messenger .tab-content .active').data('room-id'));
                var messageText = $(this);

                currentUser
                .sendMessage({
                    text: messageText.val(),
                    roomId: roomId,
                    // attachment: {
                    //   link: 'https://assets.zeit.co/image/upload/front/api/deployment-state.png',
                    //   type: 'image',
                    // },
                    attachment: undefined
                })
                .then(messageId => {
                    //console.log("Success!", messageId)
                    messageText.val('');
                    currentUser.setReadCursor({
                        roomId: roomId,
                        position: messageId
                    })
                        .then(() => {

                        })
                        .catch(err => {
                            //console.log(`Error setting cursor: ${err}`)
                        });

                    var scroll = $('#room-' + roomId);
                    var height = scroll.height() + 1080;
                    //scroll.find('.m-messenger__wrapper').each(function() {
                    //   height += $(this).height();
                    //});
                    ///scroll.find('.m-messenger__messages').scrollTop(9000);
                    //$('.m-messenger .tab-pane.active').find('.m-messenger__messages').scrollTop(9000);
                })
                .catch(error => {
                    console.log("Error", error)
                })

            }
        });

        const chatManager = new Chatkit.ChatManager({
            instanceLocator: instance_locator,
            tokenProvider: tokenProvider,
            userId: user_id
        });

        chatManager
            .connect({
                onAddedToRoom: room => {
                    //console.log("added to room: ", room);
                },
                onRemovedFromRoom: room => {
                    //console.log("removed from room: ", room);

                },
                onUserJoinedRoom: (room, user) => {
                    //console.log("user: ", user, " joined room: ", room)
                },
                onUserLeftRoom: (room, user) => {
                    //console.log("user: ", user, " left room: ", room)
                },
                onPresenceChanged: ({ previous, current }, user) => {
                    //console.log("user: ", user, " was ", previous, " but is now ", current)
                },
            })
            .then(cUser => {
                currentUser = cUser
                window.currentUser = cUser
                var domInvoice = '';
                var rooms = _.sortBy(currentUser.rooms, [function(o) { return o.lastMessageAt ? o.lastMessageAt : o.updatedAt; }]);
                rooms = rooms.reverse();
                for(var i in rooms) {
                    if (rooms[i]) {
                        //console.log(rooms[i])
                        domInvoice += subscribeRoom(rooms[i]);
                    }
                }
                $('.chat-discussions').prepend(domInvoice);

                setTimeout(function () {
                    isInitial = true;
                    mUtil.data($('.chat-discussions').get(0)).get('ps').update();
                }, 2000);


            })
            .catch(err => {
                console.log("Error on connection: ", err)
            });
        
        function renderChatContainer(room) {
            return `<div class="tab-pane" id="room-${room.id}" data-room-id="${room.id}">
                        <div class="m-messenger__messages m-scrollable m-scrollable--track" data-scrollable="true">

                        </div>
                    </div>`;
        }

        function renderMessage(message) {

            var messagePosition = user_id.toUpperCase() === message.senderId.toUpperCase() ? 'm-messenger__message--out' : 'm-messenger__message--in';

            var m_attachment = '';
            if (message.attachment) {
                switch (message.attachment.type) {
                    case "image":
                        attachment = document.createElement("img")
                        break
                    default:
                        break
                }

                attachment.className += " attachment-image"
                attachment.width = "400"
                attachment.style = "margin-top: 10px; width: 400px; height: auto; border-radius: 0; display: block;"
                attachment.src = message.attachment.link;
                m_attachment = attachment.outerHTML;
            }

            var t = '';

            //t += '<div class="m-messenger__datetime">3:15PM</div>';

            t += `<div class="m-messenger__wrapper">
                        <div class="m-messenger__message ${messagePosition}">

                            <div class="m-messenger__message-body">
                                <div class="m-messenger__message-arrow"></div>
                                <div class="m-messenger__message-content">
                                    <div class="m-messenger__message-username">
                                        ${message.senderId}
                                    </div>
                                    <div class="m-messenger__message-text">
                                        ${message.text + m_attachment}
                                    </div>
                                </div>
                                <div class="m-messenger__message-date">
                                    ${moment(message.createdAt).calendar(null, {sameElse: 'YYYY-MM-DD h:MM A', lastWeek: 'YYYY-MM-DD h:MM A'})}
                                </div>
                            </div>
                        </div>
                    </div>`;

            var m = $(`#room-${message.roomId}`).find('.m-messenger__messages').append(t);


            var isActiveTab = $('.m-messenger .tab-pane.active');
            if (isActiveTab.length > 0) {
                var scroll = $('#room-' + message.roomId).find('.m-messenger__messages');
                var height = 0;
                scroll.find('.m-messenger__wrapper').each(function() {
                    height += $(this).height();
                })
                //scroll.scrollTop(scroll.height());
                scroll.scrollTop(height);

                currentUser.setReadCursor({
                    roomId: String(isActiveTab.data('room-id')),
                    position: message.id
                })
                .then(() => {
                    //console.log('Success!')
                })
                .catch(err => {
                    //console.log(`Error setting cursor: ${err}`)
                });
            }


            var discuss = $('.chat-discussions').find(`[data-room-id="${message.roomId}"]`)
                .attr('data-last-message', message.createdAt)
                .attr('data-last-message-id', message.id);

            discuss.find('.chat-date').text(moment(message.createdAt).calendar(null, {sameElse: 'YYYY-MM-DD h:MM A', lastWeek: 'YYYY-MM-DD h:MM A'}));

            //console.log(discuss.hasClass('active'), isInitial, message.roomId)

            if (!discuss.hasClass('active') && isInitial) {
                var unreadCount = parseInt(discuss.attr('data-unread-count'));
                unreadCount++;
                discuss.attr('data-unread-count', unreadCount);
                discuss.find('.m-badge')
                    .removeClass('hidden')
                    .text(unreadCount);
            }

            if (isInitial) {
                tinysort('div.chat-discussions>div',{data:'last-message',order:'desc'});
            }

            discuss
                .find('.last-message').text(truncate(message.text, 40, {ellipsis: '...'}));

        }

        function subscribeRoom(room) {

            $('.m-messenger').find('.tab-content').append(renderChatContainer(room));
            var t = $(`#room-${room.id}`).find('.m-messenger__messages');

            mUtil.scrollerInit(t.get(0), {
                disableForMobile: !0,
                handleWindowResize: !0,
                height: function() {
                    return mUtil.isInResponsiveRange("tablet-and-mobile") && t.data("mobile-height") ? t.data("mobile-height") : t.data("height")
                }
            });

            currentUser.subscribeToRoom({
                roomId: room.id,
                hooks: {
                    onMessage: message => {
                        //console.log("new message:", message);
                        renderMessage(message);
                    },

                    onUserStartedTyping: user => {
                        //console.log(`User ${user.name} started typing`, user);
                        $("#typing-" + room.id).text(`${user.name} started typing`);
                    },
                    onUserStoppedTyping: user => {
                        //console.log(`User ${user.name} stopped typing`);
                        $("#typing-" + room.id).html('&nbsp;');
                    }
                },
            });


            return `<div class="m-widget4__item room" data-toggle="tab" href="#room-${room.id}" role="tab" data-last-message-id="" data-unread-count="${room.unreadCount}" data-room-id="${room.id}" data-last-message="${room.lastMessageAt ? room.lastMessageAt : room.createdAt}">
                        <div class="m-widget4__info">
                            <span class="m-widget4__title">
                                ${room.name}
                            </span><br>
                            <span class="m-widget4__sub last-message">
                                &nbsp;
                            </span>
                        </div>
                        <div class="m-widget4__ext room-info">
                            <span class="m-widget6__text pull-right chat-date">${moment(room.lastMessageAt).calendar(null, {sameElse: 'YYYY-MM-DD h:MM A', lastWeek: 'YYYY-MM-DD h:MM A'})}</span>
                            <span class="m-badge m-badge--info ${room.unreadCount > 0 ? '' : 'hidden'}">${room.unreadCount}</span>
                        </div>
                    </div>`;
        }


    });
</script>
<?php $this->end(); ?>



