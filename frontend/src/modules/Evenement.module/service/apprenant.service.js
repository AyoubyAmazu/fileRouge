import api from '@/axios/axios';


export const apprenantNoInscripEvent = (id)=>
{
    return api.get("/apprenant/notInscrip/"+id);
}
