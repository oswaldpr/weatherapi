import axios from "axios";
// TODO all my todo list in this file will be done step 2 (need to analyse api comportment with the pages logic)

// SERVICE EXECUTION SECTION
export function axiosOperation(serviceRoute, serviceData) {
    let params = new URLSearchParams();
    if(serviceData){
        params.append("serviceData", JSON.stringify(serviceData));
    }

    return axios.post(serviceRoute, params)
        .then(function (apiOutput) {
            return apiOutput.data;
        }).catch(function (apiError) {
            return apiError.message;
        }).finally(function (e) {
            // Finally opp
        });
}
