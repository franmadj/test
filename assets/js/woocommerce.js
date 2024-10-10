import { addFilter } from '@wordpress/hooks';
function addAccessExpiresToDownloadsReport( reportTableData ) {
    const { endpoint, items } = reportTableData;
    if ( 'downloads' !== endpoint ) {
        return reportTableData;
    }
 
    reportTableData.headers = [
        ...reportTableData.headers,
        {
            label: 'Access expires',
            key: 'access_expires',
        },
    ];
    reportTableData.rows = reportTableData.rows.map( ( row, index ) => {
        const item = items.data[ index ];
        const newRow = [
            ...row,
            {
                display: item.access_expires,
                value: item.access_expires,
            },
        ];
        return newRow;
    } );
 
    return reportTableData;
}
addFilter( 'woocommerce_admin_report_table', 'dev-blog-example', addAccessExpiresToDownloadsReport );


