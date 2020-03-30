let state = { page_id: tsw_scriptParams.length -1 , 'page_location': 0};
window.history.replaceState(state, null, "");

	
function tsw_category_content(tsw_target){
	tsw_target
state = { 'page_id': tsw_target , 'page_location': window.pageYOffset};
window.history.pushState(state, 'Main', "");
document.querySelector(".tsw_container").innerHTML = tsw_scriptParams[tsw_target];
window.scrollTo(0,0);
//if (tsw_target!==(tsw_scriptParams.length -1)){window.scrollTo(0,200);}
//else{document.querySelector('tsw_'+tsw_target).scrollIntoView({behavior: 'smooth'});}
//console.log (window.top, tsw_scriptParams.length, tsw_target);
return false;
}

window.addEventListener('popstate', function(event) {
document.querySelector(".tsw_container").innerHTML = tsw_scriptParams[history.state.page_id];
  });
                