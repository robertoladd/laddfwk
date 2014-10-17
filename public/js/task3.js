

function deleteAddress(addressid){
    if(confirm('Do you really want to delete this address?')){
        document.getElementById('deleteFrom'+addressid).submit();
    }
}