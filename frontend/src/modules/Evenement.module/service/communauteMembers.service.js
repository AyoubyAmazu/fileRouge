import api from '@/axios/axios';

export const getCounteMembers = (year) => {
    console.log('getCounteMembers', year);
   if (year && year !== '' && year !== 'null') {
    return api.get('/countMembers?year=' + year);
  } else {
    return api.get('/countMembers');
  }
};

export const getMembers = (year ) => {
    if (year && year !== '' && year !== 'null') {
        return api.get('/communauteMembers?year=' + year);
    }else {
        return api.get('/communauteMembers');
    }
};

export const getCommunaute = (year) => {
    if (year && year !== '' && year !== 'null') {
        return api.get('/communaute?year=' + year);
    } else {
        return api.get('/communaute');
    }
}

export const countMemberOfCommunaute = (communauteId) => {
    return api.get('/countMemberOfCommunaute/' + communauteId);
}
export const membersByCommunaute = (communauteId) => {

        return api.get('/membersByCommunaute/' + communauteId);

}
export const updateMemberCommunaute = (Id, memberId, data) => {
    return api.put('/communauteMembers/' + Id + '/' + memberId, data);
}
