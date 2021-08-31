(function(){
    jQuery(document).ready($ => {
        
        let logs = JSON.parse(lsWpAjax.logs);
        let type = null;
        let inDeleteProcess = false;

        $('.sub-item').on('click', function(){
            $('#ls-wp-logger-body').html('<div class="loading">Loading...</div>');
            $('.sub-item').removeClass('current');
            $(this).addClass('current');
            type = $(this).data('type') || null;
        });

        $('#remove-button').on('click', ()=>{
            $('#ls-wp-logger-body').html('<div class="loading">Loading...</div>');
            inDeleteProcess = true;
            $.post( lsWpAjax.url, {
                action:'delete_logs', 
                type: type
            }).done( data => {
                logs = JSON.parse(data);
                inDeleteProcess = false;
                if(logs){
                    updateTable();
                }
            });
        });
    
        updateTable();

        setInterval(async()=>{
            $.post( lsWpAjax.url, {
                action: 'get_logs', 
                type: type
            }).done( data => {
                if(!inDeleteProcess){
                    logs = JSON.parse(data);
                    if(logs){
                        updateTable();
                    }
                }
            });
        }, 2000);

        function updateTable() { 

            const headerItems = logs.header;
            const bodyItems = logs.body;

            let infoNumber = headerItems.find(it => it.type === 'info');
            infoNumber = parseInt( infoNumber ? infoNumber.number : 0);

            let errorNumber = headerItems.find(it => it.type === 'error');
            errorNumber = parseInt( errorNumber ? errorNumber.number : 0);

            const allNumbers = infoNumber + errorNumber;

            $('#counter-all').html(`( ${allNumbers} )`);
            $('#counter-info').html(`( ${infoNumber} )`);
            $('#counter-error').html(`( ${errorNumber} )`);

            const items = bodyItems.map((item, index) => {
                const value = JSON.stringify(JSON.parse(item.value), null, '\t');
                return `
                    <tr class="${index%2 ? '' : 'alternate'}">
                        <td class="date column-date"
                            scope="row">${item.reg_date}</td>
                        <td class="column-columnname">
                            <b>${item.title}</b>
                            <pre>${value}</pre>
                        </td>
                        <td class="column-columnname">${item.type}</td>
                    </tr>
                `;
            }).join();
            $('#ls-wp-logger-body').html(items);
        }
    });
})();