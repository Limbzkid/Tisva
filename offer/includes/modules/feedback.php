<div class="feedback-head">
	<div class="drag">
		<a class="slideout" href=""></a>
	</div>
	<div class="feedback-main">
		<a class="close_feedback" href="#close_feedback">x</a>
		<div class="dvtellus">
			<h2>Feedback</h2>
		</div>
		<div class="feedback_divider"></div>
		<div class="result">
		</div>
		<div class="feedbackFormContainer">
			<form id="frmFeedback" name="frmFeedback" enctype="multipart/form-data" method="POST" action="procesUserRequest.php">
				<input type="hidden" name="code" id="code" value="<?php echo $securityCode;?>" readonly />
				<div class="name label-text">
					Name:
				</div>
				<div>
					<input class="fullname" placeholder="Enter your name" name="user_name" id="user_name" type="text" maxlength="50" value="">
					<span class="field-validation-valid" data-valmsg-for="FullName" data-valmsg-replace="true"></span>
				</div>
				<div class="email label-text">
					Email:
				</div>
				<div>
					<input class="email" placeholder="Enter your email address" name="user_email" id="user_email" type="text" maxlength="50" value="">
					<span class="field-validation-valid" data-valmsg-for="Email" data-valmsg-replace="true"></span>
				</div>
				<div class="comment label-text">
					Suggestion:
				</div>
				<div>
					<textarea class="enquiry" cols="20" placeholder="Enter your feedback" name="user_suggestion" id="user_suggestion" maxlength="1024" rows="2"></textarea>
					<span class="field-validation-valid" data-valmsg-for="user_suggestion" data-valmsg-replace="true"></span>
				</div>
				<div class="buttons">
					<input type="submit" name="send-email" id="send-email" class="btn green right big" value="Submit">
				</div>
			</form>
		</div>
		<div class="feedbackThankYou">
			<p class="feedbackMessage">Thank you for your feedback, We will get back to you shortly</p>
		</div>
	</div><!-- 
	<div class="feedback-main" style="display: none">
		<div class="resptxt">Thank you for providing your valuable feedback.<a href="#feedbackresp" title="Close" class="fadeout close_lnk">x</a></div>
		<div class="backdrop"></div>
	</div> -->
</div>