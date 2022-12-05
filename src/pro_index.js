import { render } from '@wordpress/element';
import ProApp from "./ProApp";

let current_page = window.location.search;
if(current_page === '?page=wcs_setting'){
    render(<ProApp />, document.getElementById('wcs_setting'));
}
