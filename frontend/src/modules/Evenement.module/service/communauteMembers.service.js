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

export const memberOfCommunaute = (communauteId) => {
    return api.get('/communauteMembers/' + communauteId);
}
