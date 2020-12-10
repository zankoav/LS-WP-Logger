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