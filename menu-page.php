<style>
    .remove-logs {
        float:right;
        margin: 8px 0 0;
    }
    .remove-logs .button-link{
        line-height: 2;
        padding: .2em;
        text-decoration: none;
        font-size: 13px;
    }

    .subsubsub .sub-item:focus, #remove-button:focus{
        outline:none;
        box-shadow: none;
    }
</style>

<div class="wrap">
    <h1 class="wp-heading">LS WP Logger</h1>
    <ul class="subsubsub">
        <li><a href="javascript:void(0);" class="sub-item current">All <span id="counter-all" class="count"></span></a> |</li>
        <li><a href="javascript:void(0);" data-type="info" class="sub-item">Info <span id="counter-info" class="count"></span></a> |</li>
        <li><a href="javascript:void(0);" data-type="error" class="sub-item">Error <span id="counter-error" class="count"></span></a></li>
    </ul>
    <p class="remove-logs">
        <input type="button" id="remove-button" class="button-link button-link-delete" value="Remove Logs">
    </p>
    <table class="widefat fixed"
        cellspacing="0">
        <thead>
            <tr>
                <th id="cb"
                    class="manage-column column-date"
                    scope="col">Date</th>
                <th id="columnname"
                    class="manage-column"
                    scope="col">Message</th>
                <th id="columnname"
                    class="manage-column column-categories"
                    scope="col">Type</th>
            </tr>
        </thead>
        <tbody id="ls-wp-logger-body"></tbody>
    </table>
</div>

<script>
    let logs = JSON.parse('<?= json_encode(LS_WP_Logger::getLogs());?>') || [];

    let filterType;

    jQuery(document).ready($ => {
        updateTable();

        setInterval(async()=>{
            $.post( lsWpAjax.url, {action:'get_logs'}).done( data => {
                logs = JSON.parse(data);
                if(logs){
                    updateTable();
                }
            });
        }, 2000);

        $('.sub-item').on('click', function(){
            $('.sub-item').removeClass('current');
            $(this).addClass('current');
            filterType = $(this).data('type');
            updateTable();
        });

        $('#remove-button').on('click', ()=>{
            $.post( lsWpAjax.url, {action:'delete_logs'}).done( data => {
                logs = JSON.parse(data);
                if(logs){
                    updateTable();
                }
            });
        });

        function updateTable() { 

            $('#counter-all').html( '(' + logs.length + ')');
            $('#counter-info').html('(' + logs.filter(item => item.type === 'info').length + ')');
            $('#counter-error').html('(' + logs.filter(item => item.type === 'error').length + ')');

            let filteredLogs = [...logs];

            if(filterType){
                filteredLogs = logs.filter(item => item.type === filterType);
            }

            const items = filteredLogs.map((item, index) => {
                return `
                    <tr class="${index%2 ? '' : 'alternate'}">
                        <td class="date column-date"
                            scope="row">${item.reg_date}</td>
                        <td class="column-columnname">${item.message}</td>
                        <td class="column-columnname">${item.type}</td>
                    </tr>
                `;
            }).join();
            $('#ls-wp-logger-body').html(items);
        }
    });
</script>