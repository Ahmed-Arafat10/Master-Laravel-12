alert(routeList["TEST"].uri);


function route(name, parameters = {}) {
    let url = '';

    if (typeof routeList[name] === 'undefined') {
        console.error('Route not found.');
        return url;
    }

    url = routeList[name].uri;

    for (let parameterName in parameters) {

        let parameterValue = parameters[parameterName];
        alert(parameterName);
        url = url.replace('{' + parameterName + '}', parameterValue);
    }

    return url;
}

let x = route("TEST", {"id":10,"name":'ahmed'});
console.log("here " + x);

// let routeName = 'example';
// let url = route(routeName);
//
// fetch(url, {
//     method: 'POST',
//     headers: {
//         'X-Requested-With': 'XMLHttpRequest'
//     },
//     body: formData
// })
//     .then(response => response.json())
//     .then(data => console.log(data))
//     .catch(error => console.error(error));
