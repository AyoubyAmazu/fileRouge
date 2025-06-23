import api from '@/axios/axios';

export const getEventCount = (year) => {
    if (year && year !== '' && year !== 'null') {
        return api.get('/EventCount?year=' + year);
    } else {
        return api.get('/EventCount');
    }
};

export const getEventsYears = () => {
    return api.get('/EventYears');
}

export const getEvents = (year=null) => {

     if (year && year !== '' && year !== 'null') {
        return api.get('/EventList?year=' + year);
    } else {
        return api.get('/EventList');
    }
  }


export const getEventById = (id) => {
    return api.get('/Event/' + id);
}


export const deleteEvent = (id) => {
    return api.delete('/EventDelete/' + id);
}


export const ajouterEvent = (event) => {
    return api.post('/EventCreat', event);
}


export const updateEvent = (eventId,event) => {
    return api.put('/EventUpdate/'+eventId , event);
}

export const upcomingEvents = () =>
{
        return api.get('/Events/upcoming');
}
