<template>
    <div class="ajouter-event">
        <h1>Ajouter un Événement</h1>
        <form @submit.prevent="submitEvent">
            <div class="form-row">
                <label for="titre">Titre</label>
                <input id="titre" v-model="event.titre" required />
            </div>
            <div class="form-row">
                <label for="description">Description</label>
                <textarea id="description" v-model="event.description"></textarea>
            </div>
            <div class="form-row">
                <label for="lieu">Lieu</label>
                <input id="lieu" v-model="event.lieu" required />
            </div>
            <div class="form-row">
                <label for="date_debut">Date début</label>
                <input id="date_debut" type="date" v-model="event.date_debut" required />
            </div>
            <div class="form-row">
                <label for="date_fin">Date fin</label>
                <input id="date_fin" type="date" :min="event.date_debut" v-model="event.date_fin" required />
            </div>
            <div class="jours-section">
                <div class="jours-header">
                    <label>Jours</label>
                    <button type="button" class="add-jour-btn" @click="addJour">
                        <i class="fa fa-plus"></i> Ajouter un jour
                    </button>
                </div>
                <div v-if="event.jours.length === 0" class="no-jour">Aucun jour ajouté.</div>
                <div v-for="(jour, idx) in event.jours" :key="idx" class="jour-card">
                    <div class="jour-card-header">
                        <span class="jour-title">Jour {{ idx + 1 }}</span>
                        <button type="button" class="remove-jour-btn" @click="removeJour(idx)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <div class="jour-fields">
                        <div>
                            <label>Date</label>
                            <input type="date" :min="event.date_debut" v-model="jour.date" required />
                        </div>
                        <div>
                            <label>Heure début</label>
                            <input type="time" v-model="jour.heure_debut" required />
                        </div>
                        <div>
                            <label>Heure fin</label>
                            <input type="time" v-model="jour.heure_fin" required />
                        </div>
                        <div>
                            <label>Apporter</label>
                            <input placeholder="Apporter" v-model="jour.apporter" />
                        </div>
                        <div style="width: 100%;">
                            <label>Description</label>
                            <textarea
                                placeholder="Description"
                                v-model="jour.description"
                                class="jour-description"
                                rows="2"
                            ></textarea>
                        </div>
                        <div class="checkboxes">
                            <label>
                                <input type="checkbox" v-model="jour.pause_cafe" true-value="1" false-value="0" />
                                <span class="checkbox-label">Pause café</span>
                            </label>
                            <label>
                                <input type="checkbox" v-model="jour.pause_dejeuner" true-value="1" false-value="0" />
                                <span class="checkbox-label">Pause déjeuner</span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
            <button type="submit" class="submit-btn">Ajouter</button>
        </form>
        <div v-if="message" class="message">{{ message }}</div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { ajouterEvent } from '../../service/event.service'
const event = ref({
    titre: '',
    description: '',
    lieu: '',
    date_debut: '',
    date_fin: '',
    jours: []
})

const message = ref('')

function addJour() {
    event.value.jours.push({
        date: '',
        heure_debut: '',
        heure_fin: '',
        apporter: '',
        description: '',
        pause_cafe: 0,
        pause_dejeuner: 0
    })
}

function removeJour(idx) {
    event.value.jours.splice(idx, 1)
}

function submitEvent() {
    try {
        ajouterEvent(event.value)
        console.log('Submitting event:', event.value)
        // ajouterEvent(event.value)
    } catch (error) {
        console.error('Erreur lors de l\'ajout de l\'événement:', error)
        message.value = 'Erreur lors de l\'ajout de l\'événement.'
    }
    message.value = 'Événement ajouté avec succès !'
    // Réinitialiser le formulaire
    event.value = {
        titre: '',
        description: '',
        lieu: '',
        date_debut: '',
        date_fin: '',
        jours: []
    }
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

body {
    background: linear-gradient(120deg, #f0f4ff 0%, #f7f9fc 100%);
}

.ajouter-event {
    max-width: 650px;
    margin: 3rem auto;
    padding: 2.7rem 2.2rem 2.2rem 2.2rem;
    border-radius: 22px;
    background: #fff;
    box-shadow: 0 8px 32px rgba(99,102,241,0.13), 0 1.5px 8px #e3e9f7;
    border: none;
    position: relative;
}

.jour-description {
    width: 100%;
    min-height: 48px;
    padding: 0.7rem 1rem;
    border: 1.3px solid #e3e9f7;
    border-radius: 9px;
    background: #fff;
    font-size: 1.05rem;
    resize: vertical;
    transition: border 0.2s;
    margin-top: 0.2rem;
}
.jour-description:focus {
    border-color: #3f51b5;
    outline: none;
}

.ajouter-event h1 {
    text-align: center;
    color: #283593;
    margin-bottom: 2.5rem;
    font-size: 2.2rem;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.form-row {
    margin-bottom: 1.7rem;
    display: flex;
    flex-direction: column;
}

.form-row label {
    margin-bottom: 0.5rem;
    font-size: 1.08rem;
    color: #283593;
    font-weight: 700;
    letter-spacing: 0.1px;
}

.form-row input,
.form-row textarea {
    width: 100%;
    padding: 1rem 1.1rem;
    border: 1.7px solid #e3e9f7;
    border-radius: 11px;
    font-size: 1.13rem;
    background: #f7f9fc;
    outline: none;
    transition: border 0.2s, box-shadow 0.2s;
    margin-top: 0.1rem;
}

.form-row input:focus,
.form-row textarea:focus {
    border-color: #3f51b5;
    box-shadow: 0 2px 8px #e3e9f7;
}

.jours-section {
    margin: 2.5rem 0 2rem 0;
}

.jours-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.3rem;
}

.jours-header label {
    font-size: 1.15rem;
    font-weight: 700;
    color: #283593;
    letter-spacing: 0.1px;
}

.add-jour-btn {
    background: linear-gradient(90deg, #43a047 60%, #66bb6a 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.6rem 1.5rem;
    font-size: 1.13rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 2px 8px rgba(67,160,71,0.09);
    transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
}
.add-jour-btn:hover {
    background: linear-gradient(90deg, #388e3c 60%, #43a047 100%);
    box-shadow: 0 4px 16px rgba(67,160,71,0.13);
    transform: translateY(-2px) scale(1.03);
}

.no-jour {
    color: #888;
    font-style: italic;
    margin-bottom: 1.2rem;
    text-align: center;
}

.jour-card {
    background: linear-gradient(120deg, #f7f9fc 80%, #e3e9f7 100%);
    border: 1.7px solid #e3e9f7;
    border-radius: 18px;
    margin-bottom: 1.7rem;
    padding: 1.5rem 1.2rem 1rem 1.2rem;
    box-shadow: 0 4px 18px rgba(99,102,241,0.09);
    position: relative;
    transition: box-shadow 0.2s, border 0.2s;
}
.jour-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.1rem;
}
.jour-title {
    font-weight: 800;
    color: #3f51b5;
    font-size: 1.18rem;
    letter-spacing: 0.2px;
}
.remove-jour-btn {
    background: linear-gradient(90deg, #e53935 60%, #ff7043 100%);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.18rem;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
}
.remove-jour-btn:hover {
    background: linear-gradient(90deg, #b71c1c 60%, #e53935 100%);
    transform: scale(1.10);
}
.jour-fields {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.3rem 2rem;
    margin-bottom: 0.7rem;
}
.jour-fields label {
    font-size: 1.01rem;
    color: #3f51b5;
    margin-bottom: 0.2rem;
    font-weight: 600;
}
.jour-fields input {
    width: 100%;
    padding: 0.6rem;
    border: 1.3px solid #e3e9f7;
    border-radius: 9px;
    background: #fff;
    font-size: 1.05rem;
    margin-bottom: 0.2rem;
    transition: border 0.2s;
}
.jour-fields input:focus {
    border-color: #3f51b5;
}

/* Checkbox styles */
.checkboxes {
    grid-column: span 2;
    display: flex;
    gap: 2.5rem;
    margin-top: 0.7rem;
}
.checkboxes label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 700;
    color: #3f51b5;
    font-size: 1.07rem;
    cursor: pointer;
    user-select: none;
}
.checkbox-label {
    margin-left: 0.2rem;
}

.submit-btn {
    width: 100%;
    padding: 1rem 0;
    background: linear-gradient(90deg, #3f51b5 60%, #5c6bc0 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 1.18rem;
    font-weight: 800;
    margin-top: 2.2rem;
    cursor: pointer;
    box-shadow: 0 2px 8px #e3e9f7;
    transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
}
.submit-btn:hover {
    background: linear-gradient(90deg, #283593 60%, #3f51b5 100%);
    box-shadow: 0 4px 16px #e3e9f7;
    transform: translateY(-2px) scale(1.03);
}
.message {
    margin-top: 1.7rem;
    color: #43a047;
    text-align: center;
    font-weight: 800;
    font-size: 1.15rem;
    letter-spacing: 0.2px;
}
</style>
