<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
	<!--begin::Container-->
	<div class="container d-flex flex-column flex-md-row align-items-center justify-content-center">
		<!--begin::Copyright-->
		<div class="text-dark order-2 order-md-1">
			<span class="text-muted font-weight-bold mr-2">2020©</span>
			<a href="index.php" target="_blank" class="text-dark-75 text-hover-primary">MTL Wheels Dashboard</a>
		</div>
		<!--end::Copyright-->
	</div>
	<!--end::Container-->

	<!-- modals -->
	<div class="modal fade" tabindex="-1" role="dialog" id="myModal4">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Confirm Reset</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<strong>Are you sure about resetting users balance?</strong>
					<p>resetting balance will result in the following:
						<ul>
							<li>All users, agents, admin <strong>Balance.</strong> will be reset to 0.00</li>
						</ul>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="javascript:resetBalanceClickHandler()">Confirm</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modals -->
	<div class="modal fade" tabindex="-1" role="dialog" id="myModal5">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Confirm Reset</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<strong>Are you sure about resetting?</strong>
					<p class="text-danger mt-3">
						Please before you reset, make sure to export a copy of Audit logs and Winners logs to your device for the reason that records on database will be deleted.
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="javascript:resetClickHandler();">Confirm</button>
				</div>
			</div>
		</div>
	</div>


</div>