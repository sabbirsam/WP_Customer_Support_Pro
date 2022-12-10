import { render } from '@wordpress/element';
import ProApp from "./ProApp";

let current_page = window.location.search;
if(current_page === '?page=wcs_documentation'){
    render(<ProApp />, document.getElementById('wcs_documentation'));
}
