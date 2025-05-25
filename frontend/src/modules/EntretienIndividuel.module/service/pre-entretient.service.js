import api from '@/axios/axios';


export const getPreEntretiensByPromotion = (promotion) => {
    return api.get(`/pre-entretiens/submitted/count/${promotion}`);
};