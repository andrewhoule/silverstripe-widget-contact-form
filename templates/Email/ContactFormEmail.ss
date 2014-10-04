<html>
	<body>
		<p><a href="mailto:$Email">$Name</a> sent this through your contact form widget. Here is what he/she had to say.</p>
		<ul>
			<% if Name %><li><strong>Name:</strong> $Name</li><% end_if %>
			<% if Email %><li><strong>Email:</strong> $Email</li><% end_if %>
			<% if Message %><li><strong>Message:</strong> $Message</li><% end_if %>
		</ul>
	</body>
</html>