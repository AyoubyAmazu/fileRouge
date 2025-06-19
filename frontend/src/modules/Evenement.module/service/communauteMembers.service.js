import api from '@/axios/axios';

export const getCounteMembers = (year) => {
   if (year && year !== '' && year !== 'null') {
    return api.get('/totalMembers?year=' + year);
  } else {
    return api.get('/totalMembers');
  }
};

export const getMembers = (year ) => {
    if (year && year !== '' && year !== 'null') {
        return api.get('/apprenants_communautes?year=' + year);
    }else {
        return api.get('/apprenants_communautes');
    }
};

export const getCommunautes = (year) => {
    if (year && year !== '' && year !== 'null') {
        return api.get('/communautes?year=' + year);
    } else {
        return api.get('/communautes');
    }
}

export const countMemberOfCommunaute = (communauteId) => {
    return api.get('/countMemberOfCommunaute/' + communauteId);
}

export const membersByCommunaute = (communauteId) => {

     return api.get('/membersByCommunaute/' + communauteId);
}

export const updateMemberCommunaute = (data) => {
    return api.post('/apprenants_communautes/update/', data);
}



export const apprenantsWithNoCommunaute = () => {
    return api.get('/apprenants/no_community');
}

export const addMemberToCommunaute = (data) => {
    return api.post('/apprenants_communautes/add', data);
}
