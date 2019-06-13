<?php $this->append('style'); ?>
<?php
$this->Html->css([
'/admin-assets/vendors/swipe/css/swipe.min.css',
'/css/aos',
], ['block' => true]);
?>
<?php $this->end(); ?>


<!-- Layout -->
<div class="layout">
	<!-- Start of Navigation -->
	<nav class="navigation">
		<div class="container">
			<a href="#" class="logo" rel="home">
				<img src="" alt="logo">
			</a>
			<ul class="nav" role="tablist">
				<li><a href="#conversations" class="active" data-toggle="tab" role="tab" aria-controls="conversations" aria-selected="true"><i data-eva="message-square" data-eva-animation="pulse"></i></a></li>
				<li><a href="#friends" data-toggle="tab" role="tab" aria-controls="friends" aria-selected="false"><i data-eva="people" data-eva-animation="pulse"></i></a></li>
				<?php /*<li><a href="#notifications" data-toggle="tab" role="tab" aria-controls="notifications" aria-selected="false"><i data-eva="bell" data-eva-animation="pulse"></i></a></li>
				<li><a href="#settings" data-toggle="tab" role="tab" aria-controls="settings" aria-selected="false"><i data-eva="settings" data-eva-animation="pulse"></i></a></li>
				<li><button type="button" class="btn mode"><i data-eva="bulb" data-eva-animation="pulse"></i></button></li>
				<li><button type="button" class="btn"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-1.jpg" alt="avatar"><i data-eva="radio-button-on"></i></button></li>*/ ?>
			</ul>
		</div>
	</nav>
	<!-- End of Navigation -->
	<!-- Start of Sidebar -->
	<div class="sidebar">
		<div class="container">
			<div class="tab-content">
				<!-- Start of Discussions -->
				<div class="tab-pane fade show active" id="conversations" role="tabpanel">
					<div class="top">
						<form>
							<input type="search" class="form-control" placeholder="Search">
							<button type="submit" class="btn prepend"><i data-eva="search"></i></button>
						</form>
						<ul class="nav" role="tablist">
							<li><a href="#invoice" class="filter-btn active" data-toggle="tab" data-filter="direct">Invoice</a></li>
							<li><a href="#groups" class="filter-btn" data-toggle="tab" data-filter="groups">Groups</a></li>
						</ul>
					</div>
					<div class="middle">
						<h4>Discussions</h4>
						<button type="button" class="btn round" data-toggle="modal" data-target="#compose"><i data-eva="edit-2"></i></button>
						<hr>
						<ul class="nav discussions" role="tablist">

						</ul>
					</div>
				</div>
				<!-- End of Discussions -->
				<!-- Start of Friends -->
				<div class="tab-pane fade" id="friends" role="tabpanel">
					<div class="top">
						<form>
							<input type="search" class="form-control" placeholder="Search">
							<button type="submit" class="btn prepend"><i data-eva="search"></i></button>
						</form>
					</div>
					<div class="middle">
						<h4>Friends</h4>
						<hr>
						<ul class="users">
							<li>
								<a href="#">
									<div class="status online"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-1.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Ham Chuwon</h5>
										<span>Florida, US</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status offline"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-2.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Quincy Hensen</h5>
										<span>Shanghai, China</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status online"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-3.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Mark Hog</h5>
										<span>Olso, Norway</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status offline"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-4.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Sanne Viscaal</h5>
										<span>Helena, Montana</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status offline"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-5.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Alex Just</h5>
										<span>London, UK</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status online"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-6.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Arturo Thomas</h5>
										<span>Vienna, Austria</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status offline"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-female-1.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Victoria Garner</h5>
										<span>Chisinau, Moldova</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status offline"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-female-2.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Maria Baron</h5>
										<span>Indore, India</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
							<li>
								<a href="#">
									<div class="status online"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-female-3.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Sara Koch</h5>
										<span>Sofia, BG</span>
									</div>
									<div class="icon"><i data-eva="person"></i></div>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- End of Friends -->
                <?php /*
				<!-- Start of Notifications -->
				<div class="tab-pane fade" id="notifications" role="tabpanel">
					<div class="top">
						<form>
							<input type="search" class="form-control" placeholder="Search">
							<button type="submit" class="btn prepend"><i data-eva="search"></i></button>
						</form>
					</div>
					<div class="middle">
						<h4>Notifications</h4>
						<hr>
						<ul class="notifications">
							<li>
								<div class="round"><i data-eva="person-done"></i></div>
								<p>Quincy has joined to <strong>Squad Ghouls</strong> group.</p>
							</li>
							<li>
								<div class="round"><i data-eva="lock"></i></div>
								<p>You need change your password for security reasons.</p>
							</li>
							<li>
								<div class="round"><i data-eva="attach"></i></div>
								<p>Mark attached the file <strong>workbox.js</strong>.</p>
							</li>
							<li>
								<div class="icon round"><i data-eva="gift"></i></div>
								<p>Sara has a birthday today. Wish her all the best.</p>
							</li>
							<li>
								<div class="round"><i data-eva="person"></i></div>
								<p>Sanne has accepted your friend request.</p>
							</li>
						</ul>
					</div>
				</div>
				<!-- End of Notifications -->
				<!-- Start of Settings -->
				<div class="settings tab-pane fade" id="settings" role="tabpanel">
					<div class="user">
						<label>
							<input type="file">
							<img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-1.jpg" alt="avatar">
						</label>
						<div class="content">
							<h5>Ham Chuwon</h5>
							<span>Florida, US</span>
						</div>
					</div>
					<h4>Settings</h4>
					<ul id="preferences">
						<!-- Start of Account -->
						<li>
							<a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#account" aria-controls="account">
								<div class="title">
									<h5>Account</h5>
									<p>Update your profile details</p>
								</div>
								<i data-eva="arrow-ios-forward"></i>
								<i data-eva="arrow-ios-downward"></i>
							</a>
							<div class="content collapse" id="account" data-parent="#preferences">
								<div class="inside">
									<form class="account">
										<div class="form-row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>First Name</label>
													<input type="text" class="form-control" placeholder="First name" value="Ham">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Last Name</label>
													<input type="text" class="form-control" placeholder="Last name" value="Chuwon">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Email Address</label>
											<input type="email" class="form-control" placeholder="Enter your email address" value="hamchuwon@gmail.com">
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control" placeholder="Enter your password" value="123456">
										</div>
										<div class="form-group">
											<label>Biography</label>
											<textarea class="form-control" placeholder="Tell us a little about yourself"></textarea>
										</div>
										<button type="submit" class="btn primary">Save settings</button>
									</form>
								</div>
							</div>
						</li>
						<!-- End of Account -->
						<!-- Start of Privacy & Safety -->
						<li>
							<a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#privacy" aria-controls="privacy">
								<div class="title">
									<h5>Privacy & Safety</h5>
									<p>Control your privacy settings</p>
								</div>
								<i data-eva="arrow-ios-forward"></i>
								<i data-eva="arrow-ios-downward"></i>
							</a>
							<div class="content collapse" id="privacy" data-parent="#preferences">
								<div class="inside">
									<ul class="options">
										<li>
											<div class="headline">
												<h5>Safe Mode</h5>
												<label class="switch">
													<input type="checkbox" checked>
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
										<li>
											<div class="headline">
												<h5>History</h5>
												<label class="switch">
													<input type="checkbox" checked>
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
										<li>
											<div class="headline">
												<h5>Camera</h5>
												<label class="switch">
													<input type="checkbox">
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
										<li>
											<div class="headline">
												<h5>Microphone</h5>
												<label class="switch">
													<input type="checkbox">
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<!-- End of Privacy & Safety -->
						<!-- Start of Notifications -->
						<li>
							<a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#alerts" aria-controls="alerts">
								<div class="title">
									<h5>Notifications</h5>
									<p>Turn notifications on or off</p>
								</div>
								<i data-eva="arrow-ios-forward"></i>
								<i data-eva="arrow-ios-downward"></i>
							</a>
							<div class="content collapse" id="alerts" data-parent="#preferences">
								<div class="inside">
									<ul class="options">
										<li>
											<div class="headline">
												<h5>Pop-up</h5>
												<label class="switch">
													<input type="checkbox" checked>
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
										<li>
											<div class="headline">
												<h5>Vibrate</h5>
												<label class="switch">
													<input type="checkbox">
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
										<li>
											<div class="headline">
												<h5>Sound</h5>
												<label class="switch">
													<input type="checkbox" checked>
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
										<li>
											<div class="headline">
												<h5>Lights</h5>
												<label class="switch">
													<input type="checkbox">
													<span class="slider round"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<!-- End of Notifications -->
						<!-- Start of Integrations -->
						<li>
							<a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#integrations" aria-controls="integrations">
								<div class="title">
									<h5>Integrations</h5>
									<p>Sync your social accounts</p>
								</div>
								<i data-eva="arrow-ios-forward"></i>
								<i data-eva="arrow-ios-downward"></i>
							</a>
							<div class="content collapse" id="integrations" data-parent="#preferences">
								<div class="inside">
									<ul class="integrations">
										<li>
											<button class="btn round"><i data-eva="google"></i></button>
											<div class="content">
												<div class="headline">
													<h5>Google</h5>
													<label class="switch">
														<input type="checkbox" checked>
														<span class="slider round"></span>
													</label>
												</div>
												<span>Read, write, edit</span>
											</div>
										</li>
										<li>
											<button class="btn round"><i data-eva="facebook"></i></button>
											<div class="content">
												<div class="headline">
													<h5>Facebook</h5>
													<label class="switch">
														<input type="checkbox" checked>
														<span class="slider round"></span>
													</label>
												</div>
												<span>Read, write, edit</span>
											</div>
										</li>
										<li>
											<button class="btn round"><i data-eva="twitter"></i></button>
											<div class="content">
												<div class="headline">
													<h5>Twitter</h5>
													<label class="switch">
														<input type="checkbox">
														<span class="slider round"></span>
													</label>
												</div>
												<span>No permissions set</span>
											</div>
										</li>
										<li>
											<button class="btn round"><i data-eva="linkedin"></i></button>
											<div class="content">
												<div class="headline">
													<h5>LinkedIn</h5>
													<label class="switch">
														<input type="checkbox">
														<span class="slider round"></span>
													</label>
												</div>
												<span>No permissions set</span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<!-- End of Integrations -->
						<!-- Start of Appearance -->
						<li>
							<a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#appearance" aria-controls="appearance">
								<div class="title">
									<h5>Appearance</h5>
									<p>Customize the look of Swipe</p>
								</div>
								<i data-eva="arrow-ios-forward"></i>
								<i data-eva="arrow-ios-downward"></i>
							</a>
							<div class="content collapse" id="appearance" data-parent="#preferences">
								<div class="inside">
									<ul class="options">
										<li>
											<div class="headline">
												<h5>Lights</h5>
												<label class="switch">
													<input type="checkbox">
													<span class="slider round mode"></span>
												</label>
											</div>
											<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<!-- End of Appearance -->
					</ul>
				</div>
				<!-- End of Settings --> */ ?>
			</div>
		</div>
	</div>
	<!-- End of Sidebar -->
	<!-- Start of Chat -->
	<div class="chat">
		<div class="tab-content">
			<!-- Start of Chat Room -->

			<!-- End of Chat Room -->
		</div>
	</div>
	<!-- End of Chat -->
	<!-- Start of Compose -->
	<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="compose" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Compose</h5>
					<button type="button" class="btn round" data-dismiss="modal" aria-label="Close">
						<i data-eva="close"></i>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav" role="tablist">
						<li><a href="#details" class="active" data-toggle="tab" role="tab" aria-controls="details" aria-selected="true">Details</a></li>
						<li><a href="#participants" data-toggle="tab" role="tab" aria-controls="participants" aria-selected="false">Participants</a></li>
					</ul>
					<div class="tab-content">
						<!-- Start of Details -->
						<div class="details tab-pane fade show active" id="details" role="tabpanel">
							<form>
								<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" placeholder="What's the topic?">
								</div>
								<div class="form-group">
									<label>Message</label>
									<textarea class="form-control" placeholder="Hmm, are you friendly?"></textarea>
								</div>
							</form>
						</div>
						<!-- End of Details -->
						<!-- Start of Participants -->
						<div class="participants tab-pane fade" id="participants" role="tabpanel">
							<div class="search">
								<form>
									<input type="search" class="form-control" placeholder="Search">
									<button type="submit" class="btn prepend"><i data-eva="search"></i></button>
								</form>
							</div>
							<h4>Users</h4>
							<hr>
							<ul class="users">
								<li>
									<div class="status online"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-1.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Ham Chuwon</h5>
										<span>Florida, US</span>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="user1">
										<label class="custom-control-label" for="user1"></label>
									</div>
								</li>
								<li>
									<div class="status offline"><img src="../admin-assets/vendors/swipe/img/avatars/avatar-male-2.jpg" alt="avatar"><i data-eva="radio-button-on"></i></div>
									<div class="content">
										<h5>Quincy Hensen</h5>
										<span>Shanghai, China</span>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="user2">
										<label class="custom-control-label" for="user2"></label>
									</div>
								</li>

							</ul>
						</div>
						<!-- End of Participants -->
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn primary">Compose</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Compose -->
</div>
<!-- Layout -->


<?php
$this->Html->script([
'/admin-assets/vendors/swipe/js/vendor/jquery-slim.min.js',
'/admin-assets/vendors/swipe/js/vendor/popper.min.js',
'/admin-assets/vendors/swipe/js/vendor/feather.min.js',
'/admin-assets/vendors/swipe/js/vendor/eva.min.js',
'/admin-assets/vendors/swipe/js/vendor/bootstrap.min.js',
'/admin-assets/vendors/swipe/js/swipe.min.js',
'/admin-assets/app/js/tinysort.js',
'/admin-assets/app/js/jquery.tinysort.js',
], ['block' => true]);
?>

<?php $this->append('script'); ?>
<script>
    const user_id = '<?= $this->request->getSession()->read('Auth.Users.username'); ?>';
    const csrfToken = '<?= $this->request->getParam('_csrfToken'); ?>';
    var currentUser;
    $(document).ready(function () {
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

        const chatManager = new Chatkit.ChatManager({
            instanceLocator: 'v1:us1:643558e4-7a90-485c-b398-56de24a33bff',
            tokenProvider: tokenProvider,
            userId: user_id
        });

        chatManager
            .connect({
                onAddedToRoom: room => {
                    //console.log("added to room: ", room);
                    var domInvoice = subscribeRoom(room);
                    $('#conversations').find('.discussions').prepend(domInvoice);
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
                //var rooms = currentUser.rooms.reverse();
                var rooms = _.sortBy(currentUser.rooms, [function(o) { return o.lastMessageAt ? o.lastMessageAt : o.updatedAt; }]);
                rooms = rooms.reverse();
                for(var i in rooms) {
                    if (rooms[i]) {
                        //console.log(rooms[i])
                        domInvoice += subscribeRoom(rooms[i]);
                    }
                }
                $('#conversations').find('.discussions').prepend(domInvoice);


            })
            .catch(err => {
                console.log("Error on connection: ", err)
            });

        function renderChatContainer(room)
        {
            return `<div class="tab-pane fade" id="room-${room.id}" role="tabpanel">
                <div class="item">
                 <div class="content">
                  <div class="container">
                   <div class="top">
                    <div class="headline">
                         <div class="content">
                          <h5>Quincy Hensen</h5>
                          <span>Away</span>
                         </div>
                        </div>
                        <ul>
                         <li><button type="button" class="btn" data-toggle="modal" data-target="#compose"><i data-eva="person-add" data-eva-animation="pulse"></i></button></li>
                         <li><button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-eva="more-vertical" data-eva-animation="pulse"></i></button>
                          <div class="dropdown-menu">
                           <button type="button" class="dropdown-item" data-toggle="modal" data-target="#compose"><i data-eva="person-add"></i>Add people</button>
                          </div>
                         </li>
                        </ul>
                       </div>
                      </div>
                      <div class="middle" id="scroll">
                       <div class="container">
                        <ul>

                        </ul>
                       </div>
                      </div>
                      <div class="container">
                       <div class="bottom">
                        <form class="message-to-send" data-room-id="${room.id}">
                         <input class="form-control" placeholder="Type message..." rows="1"></input>
                         <button type="submit" class="btn prepend"><i data-eva="paper-plane"></i></button>
                        </form>
                        <span class="typing" style=""></span>
                       </div>
                      </div>
                     </div>

                    </div>
                   </div>`;
        }

        function renderMessage(message) {
            var template = '';
            if (user_id.toUpperCase() === message.senderId.toUpperCase()) {
                template += `<li>
                          <div class="content">
                            <span style="color: #555555; margin-bottom: 10px;">${message.senderId}</span>
                           <div class="message">
                            <div class="bubble">
                             <p>${message.text}</p>
                            </div>
                           </div>
                           <span class="msg-date">${moment(message.createdAt).calendar(null, {sameElse: 'YYYY-MM-DD h:MM A'})} <!-- <i data-eva="done-all"></i> --></span>
                          </div>
                         </li>`;
            } else {
                template += `<li class="left">
                          <div class="content">
                            <span style="color: #555555; margin-bottom: 10px;">${message.senderId}</span>
                           <div class="message">
                            <div class="bubble">
                             <p>${message.text}</p>
                            </div>
                           </div>
                           <span class="msg-date">${moment(message.createdAt).calendar(null, {sameElse: 'YYYY-MM-DD h:MM A'})}</span>
                          </div>
                         </li>`;
            }

            $('#room-' + message.roomId).find('#scroll ul').append(template);
            var scroll = $('#room-' + message.roomId).find('#scroll');
            scroll.scrollTop(scroll.find('ul').height());

            var roomList = $('[aria-controls="room-'+message.roomId+'"]');
            roomList.attr('data-last-message', message.createdAt)
                .find('p').html(message.text);

            roomList.find('span').text(moment(message.createdAt).calendar(null, {sameElse: 'YYYY-MM-DD h:MM A'}));

            //sort list

            /*$('.discussions li').sort(function (a, b) {
                var contentA = (new Date($(a).find('a').attr('data-last-message'))).getTime();
                var contentB = (new Date($(b).find('a').attr('data-last-message'))).getTime();
                return (contentA > contentB) ? -1 : (contentA < contentB) ? 1 : 0;
            }).appendTo('.discussions');*/
            tinysort('ul.discussions>li',{selector:'a',data:'last-message',order:'desc'});


        }

        function subscribeRoom(room) {
            //console.log("Going to subscribe to", room)

            var chatRoom = renderChatContainer(room);

            $('.chat').find('.tab-content').append(chatRoom);

            currentUser.subscribeToRoom({
                roomId: room.id,
                hooks: {
                    onMessage: message => {
                        //console.log("new message:", message);
                        renderMessage(message);
                    },

                    onUserStartedTyping: user => {
                        //console.log(`User ${user.name} started typing`, user);
                        $("#room-" + room.id).find('.typing').text(`${user.name} started typing`);
                    },
                    onUserStoppedTyping: user => {
                        //console.log(`User ${user.name} stopped typing`);
                        $("#room-" + room.id).find('.typing').text('');
                    }
                },
            });
            var unreadCount = room.unreadCount > 0 ? `<span class="badge">${room.unreadCount}</span>` : '';
            unreadCount = '';

            return `<li>
                <a href="#room-${room.id}" data-last-message="${room.lastMessageAt ? room.lastMessageAt : room.createdAt}" class="filter invoice" data-chat="open" data-toggle="tab" role="tab" aria-controls="room-${room.id}" aria-selected="true">
                    <div class="content">
                        <div class="headline">
                            <h5>${room.name}</h5>
                            <span class="msg-date">${moment(room.lastMessageAt).calendar(null, {sameElse: 'YYYY-MM-DD h:MM A'})}</span>
                        </div>
                    <p></p>
                    </div>
                </a>
                </li>`;
        }

        $(document).on('click', '[data-chat="open"]', function() {
            $('.chat').toggleClass('open');
            var target = $(this).attr('aria-controls');
            var scroll = $('#' + target).find('#scroll');
            setTimeout(function() {
                scroll.scrollTop(scroll.find('ul').height());
            }, 100);

            eva.replace();
        });

        $(document).on('keyup', 'form.message-to-send input', function () {
            //console.log('sedang menulis');
            var roomId = $(this).parents('form')
                .data('room-id').toString();
            currentUser.isTypingIn({ roomId: roomId })
                .then(() => {
                    //console.log('Success!')
                })
                .catch(err => {
                    //console.log(`Error sending typing indicator: ${err}`)
                });
        });

        $(document).on('submit', '.message-to-send', function(e) {
           e.preventDefault();
           var roomId = $(this).data('room-id').toString();
           var messageToSend = $(this).find('input');
            currentUser
                .sendMessage({
                    text: messageToSend.val(),
                    roomId: roomId,
                    // attachment: {
                    //   link: 'https://assets.zeit.co/image/upload/front/api/deployment-state.png',
                    //   type: 'image',
                    // },
                    attachment: undefined
                })
                .then(messageId => {
                    console.log("Success!", messageId)
                    messageToSend.val('');
                    var scroll = $('#room-' + roomId).find('#scroll');
                    scroll.scrollTop(scroll.find('ul').height());
                })
                .catch(error => {
                    console.log("Error", error)
                })


        });


    });
</script>
<?php $this->end(); ?>


