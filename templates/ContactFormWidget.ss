<div class="widget-contact-form">
	<% if $Title %><h2>$Title</h2><% end_if %>
	<% if $ContactFormContent %>
		<div class="contact-form-content">$ContactFormContent</div><!-- .contact-form-content -->
	<% end_if %>
	$ContactForm
</div><!-- .widget-contact-form -->