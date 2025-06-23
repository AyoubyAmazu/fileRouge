import api from '@/axios/axios';

export const countTotalInscription= (year) =>
{
    if (year && year !== '' && year !== 'null') {
        return api.get('/inscription/total?year=' + year);
    } else {
    return api.get('/inscription/total');
    }
};

export const countTotalPresence = (year) =>
{
    if (year && year !== '' && year !== 'null') {
        return api.get('/inscription/total/presence?year=' + year);
    } else {
        return api.get('/inscription/total/presence');
    }
}

export const countInscriptionByEvent = (id) =>
{
    return api.get('/inscription/evenment?id='+id)

}

export const countPresenceByEvent = (id) =>
{

    return api.get('/inscription/evenment/presence?id='+id)
}

export const getInscriptionByEvent = (id) =>
{
    return api.get('/inscription/evenment/'+id)
}

export const creatInscription = (data)=>
{
        return api.post("/inscription/add",data)
}

export const updateInscriptionPresence = (data,id)=>
{
    return api.put(`/inscription/update/${id}`,data);
}

export const deleteInscription = (id)=>
{
    return api.delete("/inscription/delete/"+id);
}
