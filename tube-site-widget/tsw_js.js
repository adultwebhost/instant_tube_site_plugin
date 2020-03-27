function tsw_modal(tsw_target) {
    document.querySelector(".tsw_iframe").innerHTML = tsw_scriptParams[tsw_target];
}
	document.querySelector(".close").addEventListener("click", function(){  document.querySelector(".tsw_iframe").innerHTML = "" });