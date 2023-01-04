import "./app.scss";
const ProApp = () => {
    let current_page = window.location.search;
    if(current_page === '?page=wcs_documentation'){
        return (
            <div id="wcs_documentation">Documentation page showing from pro plugin</div>
        );
    }
    
}
export default ProApp; 