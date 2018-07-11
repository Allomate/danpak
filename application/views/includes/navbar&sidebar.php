<nav class="navbar navbar-inverse navbar-fixed-top" style="z-index: 10;">
	<div class="mobile-only-brand pull-left">
		<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);">
			<i class="zmdi zmdi-menu"></i>
		</a>
		<div class="m-logo">
			<a href="<?= base_url('Dashboard/Home'); ?>">
				<img class="brand-img" src="<?= base_url('assets/images/allomate-logo.svg?v=1.0'); ?>" alt="brand" />
			</a>
		</div>
		<a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);">
			<i class="zmdi zmdi-search"></i>
		</a>
		<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);">
			<i class="zmdi zmdi-more"></i>
		</a>
	</div>

	<div id="mobile_only_nav" class="mobile-only-nav pull-right">
		<form id="search_form" role="search" class="top-nav-search collapse pull-left">
			<div class="input-group">
				<input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default" data-target="#search_form">
						<i class="zmdi zmdi-search"></i>
					</button>
				</span>
			</div>
		</form>
		<ul class="nav navbar-right top-nav pull-right">
			<li class="dropdown auth-drp">
				<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
					<img src="<?= base_url('assets/images/profile-img.jpg'); ?>" alt="" class="user-auth-img img-circle" />
					<span class="user-online-status"></span>
				</a>
				<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
					<li>
						<a href="profile.html">
							<i class="zmdi zmdi-account"></i>
							<span>Profile</span>
						</a>
					</li>
					<li>
						<a href="inbox.html">
							<i class="zmdi zmdi-email"></i>
							<span>Inbox</span>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="zmdi zmdi-settings"></i>
							<span>Settings</span>
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="<?= base_url('Login/SignOut'); ?>">
							<i class="zmdi zmdi-power"></i>
							<span>Log Out</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr">
					<div class="pull-left">
						<i class="icon-dash1-icon mr-20"></i>
						<span class="right-nav-text">Dashboard</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="dashboard_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Dashboard/Dashboardv1'); ?>">Sales Dashboard</a>
					</li>
					<li>
						<a href="<?= base_url('Dashboard/DashboardHrm'); ?>">Employee Dashboard</a>
					</li>
					<li>
						<a href="<?= base_url('Dashboard/DashboardSales'); ?>">Inventory Analytics</a>
					</li>
					<li>
						<a href="<?= base_url('Dashboard/Reports'); ?>">Reporting</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#org_dr">
					<div class="pull-left">
						<i class="icon-org1-icon mr-20"></i>
						<span class="right-nav-text">Organization</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="org_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Organization/Profile'); ?>">Company Profile</a>
					</li>
					<li>
						<a href="<?= base_url('Regions/ListRegions');?>">Region</a>
					</li>
					<li>
						<a href="<?= base_url('Areas/ListAreas');?>">Area</a>
					</li>
					<li>
						<a href="<?= base_url('Territories/ListTerritories');?>">Territory</a>
						</i>
					</li>
					<li>
						<a href="<?= base_url('Employees/ListEmployees');?>">Employees</a>
					</li>
					<li>
						<a href="<?= base_url('AccRights/ListRights');?>">Access Rights</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#sfm_dr">
					<div class="pull-left">
						<i class="zmdi zmdi-chart mr-20"></i>
						<span class="right-nav-text">Sales Force Management</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="sfm_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Employees/AddEmployee'); ?>">Add New Sales Agent</a>
					</li>
					<li>
						<a href="<?= base_url('Employees/ListEmployees'); ?>">Sales Agent</a>
					</li>
					<li>
						<a href="<?= base_url('Employees/Attendance');?>">Attendance Management</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/EmployeesList'); ?>">Order Compliance</a>
					</li>
					<li>
						<a href="<?= base_url('Employees/DailyRouting');?>">Daily Routing</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#inv_dr">
					<div class="pull-left">
						<i class="icon-inv-icon mr-20"></i>
						<span class="right-nav-text">Inventory Management</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="inv_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Inventory/AddInventory'); ?>">Add New Product</a>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ListInventory'); ?>">Update Product</a>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ProductGallery'); ?>">Product Gallery</a>
					</li>
					<li>
						<a href="javascript:void(0);" data-toggle="collapse" data-target="#categ_dr">
							<div class="pull-left">
								<span class="left-nav-text">Categories</span>
							</div>
							<div class="pull-right m-t-5">
								<i class="zmdi zmdi-caret-down"></i>
							</div>
							<div class="clearfix"></div>
						</a>
						<ul id="categ_dr" class="innerUl collapse collapse-level-1">
							<li>
								<a href="<?= base_url('Categories/ListMainCategories'); ?>">Main Categories</a>
							</li>
							<li>
								<a href="<?= base_url('Categories/ListSubCategories'); ?>">Sub Categories</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ListSubInventory'); ?>">Sub-Inventory Management</a>
					</li>
					<li>
						<a href="<?= base_url('Inventory/ListUnits'); ?>">Packaging Options</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#cat_dr">
					<div class="pull-left">
						<i class="icon-cat1-icon mr-20"></i>
						<span class="right-nav-text">Catalogue</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="cat_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Catalogue/ViewCatalogues');?>">Catalogue Management</a>
					</li>
					<li>
						<a href="<?= base_url('Catalogue/ViewCatalogueAssignments');?>">Catalogue Assignments</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#ret_dr">
					<div class="pull-left">
						<i class="icon-ret1-icon mr-20"></i>
						<span class="right-nav-text">Distributors</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="ret_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Retailers/ListRetailers'); ?>">Distributors Management</a>
						<a href="<?= base_url('Retailers/ListRetailerTypes'); ?>">Distributor Type Management</a>
						<a href="<?= base_url('Retailers/ListRetailersAssignments'); ?>">Distributors Assignment</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#real_ret_dr">
					<div class="pull-left">
						<i class="icon-ret1-icon mr-20"></i>
						<span class="right-nav-text">Retailers</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="real_ret_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('RealRetailers/ListRetailers'); ?>">Retailers Management</a>
						<a href="<?= base_url('RealRetailers/ListRetailerTypes'); ?>">Retailer Type Management</a>
						<a href="<?= base_url('RealRetailers/ListRetailersAssignments'); ?>">Retailers Assignment</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#ord_dr">
					<div class="pull-left">
						<i class="icon-ord1-icon mr-20"></i>
						<span class="right-nav-text">Orders</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="ord_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Orders/ManualOrders'); ?>">Order Entry</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Latest'); ?>">Today's Orders</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Pending'); ?>">New Orders</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Processed'); ?>">Processed Orders</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Completed'); ?>">Completed Orders</a>
					</li>
					<li>
						<a href="<?= base_url('Orders/ListOrders/Cancelled'); ?>">Cancelled Orders</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#bulletins_dr">
					<div class="pull-left">
						<i class="zmdi zmdi-widgets"></i>
						<span class="right-nav-text">Bulletins & Questionnaires</span>
					</div>
					<div class="pull-right m-t-5">
						<i class="zmdi zmdi-caret-down"></i>
					</div>
					<div class="clearfix"></div>
				</a>
				<ul id="bulletins_dr" class="innerUl collapse collapse-level-1">
					<li>
						<a href="<?= base_url('Bulletins/ListGroups'); ?>">Groups Management</a>
					</li>
					<li>
						<a href="<?= base_url('Bulletins/ListMessages'); ?>">Message Broadcast</a>
					</li>
					<li>
						<a href="<?= base_url('Questionnaires/ListQuestionnaires'); ?>">Questionnaires</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="<?= base_url('CampaignManagement/ListCampaigns');?>">
					<div class="pull-left">
						<i class="zmdi zmdi-chart-donut"></i>
						<span class="right-nav-text">Campaign Management</span>
					</div>
					<div class="clearfix"></div>
				</a>
			</li>
			<!-- <li class="corner">
				<a href="<?= base_url('Dashboard/Reports'); ?>">
					<div class="pull-left">
						<i class="zmdi zmdi-chart-donut"></i>
						<span class="right-nav-text">Reports</span>
					</div>
					<div class="clearfix"></div>
				</a>
			</li> -->
	</ul>
</div>
<div class="fixed-sidebar-right">
	<ul class="right-sidebar">
		<li>
			<div class="tab-struct custom-tab-1">
				<ul role="tablist" class="nav nav-tabs" id="right_sidebar_tab">
					<li class="active" role="presentation">
						<a aria-expanded="true" data-toggle="tab" role="tab" id="chat_tab_btn" href="#chat_tab">chat</a>
					</li>
					<li role="presentation" class="">
						<a data-toggle="tab" id="messages_tab_btn" role="tab" href="#messages_tab" aria-expanded="false">messages</a>
					</li>
					<li role="presentation" class="">
						<a data-toggle="tab" id="todo_tab_btn" role="tab" href="#todo_tab" aria-expanded="false">todo</a>
					</li>
				</ul>
				<div class="tab-content" id="right_sidebar_content">
					<div id="chat_tab" class="tab-pane fade active in" role="tabpanel">
						<div class="chat-cmplt-wrap">
							<div class="chat-box-wrap">
								<div class="add-friend">
									<a href="javascript:void(0)" class="inline-block txt-grey">
										<i class="zmdi zmdi-more"></i>
									</a>
									<span class="inline-block txt-dark">users</span>
									<a href="javascript:void(0)" class="inline-block text-right txt-grey">
										<i class="zmdi zmdi-plus"></i>
									</a>
									<div class="clearfix"></div>
								</div>
								<form role="search" class="chat-search pl-15 pr-15 pb-15">
									<div class="input-group">
										<input type="text" id="example-input1-group2" name="example-input1-group2" class="form-control" placeholder="Search">
										<span class="input-group-btn">
											<button type="button" class="btn  btn-default">
												<i class="zmdi zmdi-search"></i>
											</button>
										</span>
									</div>
								</form>
								<div id="chat_list_scroll">
									<div class="nicescroll-bar">
										<ul class="chat-list-wrap">
											<li class="chat-list">

											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="recent-chat-box-wrap">
								<div class="recent-chat-wrap">
									<div class="panel-heading ma-0">
										<div class="goto-back">
											<a id="goto_back" href="javascript:void(0)" class="inline-block txt-grey">
												<i class="zmdi zmdi-chevron-left"></i>
											</a>
											<span class="inline-block txt-dark">ryan</span>
											<a href="javascript:void(0)" class="inline-block text-right txt-grey">
												<i class="zmdi zmdi-more"></i>
											</a>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="panel-wrapper collapse in">
										<div class="panel-body pa-0">
											<div class="chat-content">
												<ul class="nicescroll-bar pt-20">
													<li class="friend">
														<div class="friend-msg-wrap">
															<img class="user-img img-circle block pull-left" src="<?= base_url('assets/dist/img/user.png'); ?>" alt="user" />
															<div class="msg pull-left">
																<p>Hello Jason, how are you, it's been a long time since we last met?</p>
																<div class="msg-per-detail text-right">
																	<span class="msg-time txt-grey">2:30 PM</span>
																</div>
															</div>
															<div class="clearfix"></div>
														</div>
													</li>
													<li class="self mb-10">
														<div class="self-msg-wrap">
															<div class="msg block pull-right"> Oh, hi Sarah I'm have got a new job now and is going great.
																<div class="msg-per-detail text-right">
																	<span class="msg-time txt-grey">2:31 pm</span>
																</div>
															</div>
															<div class="clearfix"></div>
														</div>
													</li>
													<li class="self">
														<div class="self-msg-wrap">
															<div class="msg block pull-right"> How about you?
																<div class="msg-per-detail text-right">
																	<span class="msg-time txt-grey">2:31 pm</span>
																</div>
															</div>
															<div class="clearfix"></div>
														</div>
													</li>
													<li class="friend">
														<div class="friend-msg-wrap">
															<img class="user-img img-circle block pull-left" src="<?= base_url('assets/dist/img/user.png'); ?>" alt="user" />
															<div class="msg pull-left">
																<p>Not too bad.</p>
																<div class="msg-per-detail  text-right">
																	<span class="msg-time txt-grey">2:35 pm</span>
																</div>
															</div>
															<div class="clearfix"></div>
														</div>
													</li>
												</ul>
											</div>
											<div class="input-group">
												<input type="text" id="input_msg_send" name="send-msg" class="input-msg-send form-control" placeholder="Type something">
												<div class="input-group-btn emojis">
													<div class="dropup">
														<button type="button" class="btn  btn-default  dropdown-toggle" data-toggle="dropdown">
															<i class="zmdi zmdi-mood"></i>
														</button>
														<ul class="dropdown-menu dropdown-menu-right">
															<li>
																<a href="javascript:void(0)">Action</a>
															</li>
															<li>
																<a href="javascript:void(0)">Another action</a>
															</li>
															<li class="divider"></li>
															<li>
																<a href="javascript:void(0)">Separated link</a>
															</li>
														</ul>
													</div>
												</div>
												<div class="input-group-btn attachment">
													<div class="fileupload btn  btn-default">
														<i class="zmdi zmdi-attachment-alt"></i>
														<input type="file" class="upload">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="messages_tab" class="tab-pane fade" role="tabpanel">
						<div class="message-box-wrap">
							<div class="msg-search">
								<a href="javascript:void(0)" class="inline-block txt-grey">
									<i class="zmdi zmdi-more"></i>
								</a>
								<span class="inline-block txt-dark">messages</span>
								<a href="javascript:void(0)" class="inline-block text-right txt-grey">
									<i class="zmdi zmdi-search"></i>
								</a>
								<div class="clearfix"></div>
							</div>
							<div class="set-height-wrap">
								<div class="streamline message-box nicescroll-bar">
									<a href="javascript:void(0)">
										<div class="sl-item unread-message">
											<div class="sl-avatar avatar avatar-sm avatar-circle">
												<img class="img-responsive img-circle" src="<?= base_url('assets/dist/img/user.png'); ?>" alt="avatar" />
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font   pull-left message-per">Clay Masse</span>
												<span class="inline-block font-11  pull-right message-time">12:28 AM</span>
												<div class="clearfix"></div>
												<span class=" truncate message-subject">Themeforest message sent via your envato market profile</span>
												<p class="txt-grey truncate">Neque porro quisquam est qui dolorem ipsu messm quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0)">
										<div class="sl-item">
											<div class="sl-avatar avatar avatar-sm avatar-circle">
												<img class="img-responsive img-circle" src="<?= base_url('assets/dist/img/user1.png'); ?>" alt="avatar" />
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font   pull-left message-per">Evie Ono</span>
												<span class="inline-block font-11  pull-right message-time">1 Feb</span>
												<div class="clearfix"></div>
												<span class=" truncate message-subject">Pogody theme support</span>
												<p class="txt-grey truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0)">
										<div class="sl-item">
											<div class="sl-avatar avatar avatar-sm avatar-circle">
												<img class="img-responsive img-circle" src="<?= base_url('assets/dist/img/user2.png'); ?>" alt="avatar" />
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font   pull-left message-per">Madalyn Rascon</span>
												<span class="inline-block font-11  pull-right message-time">31 Jan</span>
												<div class="clearfix"></div>
												<span class=" truncate message-subject">Congratulations from design nominees</span>
												<p class="txt-grey truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0)">
										<div class="sl-item unread-message">
											<div class="sl-avatar avatar avatar-sm avatar-circle">
												<img class="img-responsive img-circle" src="<?= base_url('assets/dist/img/user3.png'); ?>" alt="avatar" />
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font   pull-left message-per">Ezequiel Merideth</span>
												<span class="inline-block font-11  pull-right message-time">29 Jan</span>
												<div class="clearfix"></div>
												<span class=" truncate message-subject">Themeforest item support message</span>
												<p class="txt-grey truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0)">
										<div class="sl-item unread-message">
											<div class="sl-avatar avatar avatar-sm avatar-circle">
												<img class="img-responsive img-circle" src="<?= base_url('assets/dist/img/user4.png'); ?>" alt="avatar" />
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font   pull-left message-per">Jonnie Metoyer</span>
												<span class="inline-block font-11  pull-right message-time">27 Jan</span>
												<div class="clearfix"></div>
												<span class=" truncate message-subject">Help with beavis contact form</span>
												<p class="txt-grey truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0)">
										<div class="sl-item">
											<div class="sl-avatar avatar avatar-sm avatar-circle">
												<img class="img-responsive img-circle" src="<?= base_url('assets/dist/img/user.png'); ?>" alt="avatar" />
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font   pull-left message-per">Priscila Shy</span>
												<span class="inline-block font-11  pull-right message-time">19 Jan</span>
												<div class="clearfix"></div>
												<span class=" truncate message-subject">Your uploaded theme is been selected</span>
												<p class="txt-grey truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</div>
									</a>
									<a href="javascript:void(0)">
										<div class="sl-item">
											<div class="sl-avatar avatar avatar-sm avatar-circle">
												<img class="img-responsive img-circle" src="<?= base_url('assets/dist/img/user1.png'); ?>" alt="avatar" />
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font   pull-left message-per">Linda Stack</span>
												<span class="inline-block font-11  pull-right message-time">13 Jan</span>
												<div class="clearfix"></div>
												<span class=" truncate message-subject"> A new rating has been received</span>
												<p class="txt-grey truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div id="todo_tab" class="tab-pane fade" role="tabpanel">
						<div class="todo-box-wrap">
							<div class="add-todo">
								<a href="javascript:void(0)" class="inline-block txt-grey">
									<i class="zmdi zmdi-more"></i>
								</a>
								<span class="inline-block txt-dark">todo list</span>
								<a href="javascript:void(0)" class="inline-block text-right txt-grey">
									<i class="zmdi zmdi-plus"></i>
								</a>
								<div class="clearfix"></div>
							</div>
							<div class="set-height-wrap">
								<ul class="todo-list nicescroll-bar">
									<li class="todo-item">
										<div class="checkbox checkbox-default">
											<input type="checkbox" id="checkbox01" />
											<label for="checkbox01">Record The First Episode</label>
										</div>
									</li>
									<li>
										<hr class="light-grey-hr" />
									</li>
									<li class="todo-item">
										<div class="checkbox checkbox-pink">
											<input type="checkbox" id="checkbox02" />
											<label for="checkbox02">Prepare The Conference Schedule</label>
										</div>
									</li>
									<li>
										<hr class="light-grey-hr" />
									</li>
									<li class="todo-item">
										<div class="checkbox checkbox-warning">
											<input type="checkbox" id="checkbox03" checked/>
											<label for="checkbox03">Decide The Live Discussion Time</label>
										</div>
									</li>
									<li>
										<hr class="light-grey-hr" />
									</li>
									<li class="todo-item">
										<div class="checkbox checkbox-success">
											<input type="checkbox" id="checkbox04" checked/>
											<label for="checkbox04">Prepare For The Next Project</label>
										</div>
									</li>
									<li>
										<hr class="light-grey-hr" />
									</li>
									<li class="todo-item">
										<div class="checkbox checkbox-danger">
											<input type="checkbox" id="checkbox05" checked/>
											<label for="checkbox05">Finish Up AngularJs Tutorial</label>
										</div>
									</li>
									<li>
										<hr class="light-grey-hr" />
									</li>
									<li class="todo-item">
										<div class="checkbox checkbox-purple">
											<input type="checkbox" id="checkbox06" checked/>
											<label for="checkbox06">Finish Infinity Project</label>
										</div>
									</li>
									<li>
										<hr class="light-grey-hr" />
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>
<input type="text" id="getAccRightsUrlAjax" value="<?= base_url('AccRights/GetRightsForLoggedInAdminAjax'); ?>" hidden>
