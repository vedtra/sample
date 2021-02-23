
<ul class="navigation navigation-main navigation-accordion">
	<!-- Main -->
	<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
	@if(Route::has('home'))
		<li class="{{(Route::currentRouteName()=='home'?'active':'')}}">
			<a href="{{route('home')}}" title="Role">
				<i class="icon-home2"></i>
				Home
			</a>
		</li>
	@endif
	<li>
		<a href="#" class="has-ul"><i class="icon-stack2"></i> <span>Master Data</span></a>
		<ul class="hidden-ul">
			<li>
				<a href="#" class="has-ul"><i class="icon-stack2"></i> <span>Company</span></a>
				<ul class="hidden-ul">
					@if(Route::has('categorycompanyindex'))
					<li class="{{(Route::currentRouteName()=='categorycompanyindex'?'active':'')}}">
						<a href="{{route('categorycompanyindex')}}" title="Category Company">
							<i class="icon-hat"></i>
							Company Category
						</a>
					</li>
					@endif
					@if(Route::has('companyindex'))
					<li class="{{(Route::currentRouteName()=='categorycompanyindex'?'active':'')}}">
						<a href="{{route('companyindex')}}" title="Role">
							<i class="icon-hat"></i>
							Company
						</a>
					</li>
					@endif

					@if(Route::has('accountcompanyindex'))
					<li class="{{(Route::currentRouteName()=='accountcompanyindex'?'active':'')}}">
						<a href="{{route('accountcompanyindex')}}" title="Role">
							<i class="icon-hat"></i>
							User Company
						</a>
					</li>
					@endif

					@if(Route::has('setupeditcompany'))
					<li class="{{(Route::currentRouteName()=='setupeditcompany'?'active':'')}}">
						<a href="{{route('setupeditcompany')}}" title="Role">
							<i class="icon-hat"></i>
							Setup
						</a>
					</li>
					@endif
					
					@if(Route::has('setupeditoperational'))
					<li class="{{(Route::currentRouteName()=='setupeditoperational'?'active':'')}}">
						<a href="{{route('setupeditoperational')}}" title="Role">
							<i class="icon-hat"></i>
							Operational
						</a>
					</li>
					@endif
				</ul>
			</li>
			<li>
				<a href="#" class="has-ul"><i class="icon-stack2"></i> <span>Transport</span></a>
				<ul class="hidden-ul">
					@if(Route::has('categorytransportindex'))
					<li class="{{(Route::currentRouteName()=='categorytransportindex'?'active':'')}}">
						<a href="{{route('categorytransportindex')}}" title="Role">
							<i class="icon-hat"></i>
							Transport Category
						</a>
					</li>
					@endif
					@if(Route::has('typetransportindex'))
					<li class="{{(Route::currentRouteName()=='typetransportindex'?'active':'')}}">
						<a href="{{route('typetransportindex')}}" title="Role">
							<i class="icon-hat"></i>
							Transport Type
						</a>
					</li>
					@endif
					@if(Route::has('transportindex'))
					<li class="{{(Route::currentRouteName()=='transportindex'?'active':'')}}">
						<a href="{{route('transportindex')}}" title="Role">
							<i class="icon-hat"></i>
							Transport
						</a>
					</li>
					@endif
				</ul>
			</li>


			
			@if(Route::has('blogindex'))
			<li class="{{(Route::currentRouteName()=='blogindex'?'active':'')}}">
				<a href="{{route('blogindex')}}" title="Role">
					<i class="icon-hat"></i>
					Blog
				</a>
			</li>
			@endif
			@if(Route::has('couponindex'))
			<li class="{{(Route::currentRouteName()=='couponindex'?'active':'')}}">
				<a href="{{route('couponindex')}}" title="Role">
					<i class="icon-hat"></i>
					Coupon
				</a>
			</li>
			@endif
		</ul>
	</li>
@can('Acces Configuration')
	<li>
		<a href="#" class="has-ul"><i class="icon-cog2"></i> <span>Configuration</span></a>
		<ul class="hidden-ul">
			
			@if(Route::has('accountindex'))
				@can('Account Manager')
					<li class="{{(Route::currentRouteName()=='accountindex'?'active':'')}}">
						<a href="{{route('accountindex')}}" title="Role">
							<i class="icon-users"></i>
							Account Manager
						</a>
					</li>
				@endcan
			@endif
			
			@if(Route::has('roleindex'))
			<li class="{{(Route::currentRouteName()=='roleindex'?'active':'')}}">
				<a href="{{route('roleindex')}}" title="Role">
					<i class="icon-hat"></i>
					Role
				</a>
			</li>
			@endif
			@if(Route::has('permissionindex'))
			<li class="{{(Route::currentRouteName()=='permissionindex'?'active':'')}}">
				<a href="{{route('permissionindex')}}" title="Role">
					<i class="icon-cog2"></i>
					Permission
				</a>
			</li>
			@endif
			@if(Route::has('permissionmanager'))
			<li class="{{(Route::currentRouteName()=='permissionmanager'?'active':'')}}">
				<a href="{{route('permissionmanager')}}" title="Role">
					<i class="icon-lock"></i>
					Permission Manager
				</a>
			</li>
			@endif
		</ul>
	</li>
	@endcan
</ul>
