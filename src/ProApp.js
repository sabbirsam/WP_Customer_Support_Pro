import "./app.scss";
const ProApp = () => {
    let current_page = window.location.search;

    if(current_page === '?page=wcs_setting'){
        return (
            <div id="wcs_setting">Setting page showing frpm pro plugin</div>
        );
    }
    
}
export default ProApp; 