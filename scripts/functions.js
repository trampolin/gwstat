function showNotification(aMessage,aTheme) {
	$.jGrowl(aMessage, {theme: aTheme});
}

function showDebugNotification(aMessage) {
	$.jGrowl(aMessage, {theme: 'debug'});
}

function checkResult(response) {
	if (response != undefined)
	{
		if (debug && response.debugInfo != null)
		{
			showDebugNotification(response.debugInfo);
		}
		return (response.result != undefined) && (response.result == "ok")
	}
	else
	{
		return false;
	}

}