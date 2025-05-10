import os
import time
import gradio as gr
from langchain_google_genai import ChatGoogleGenerativeAI
from langchain_core.prompts import PromptTemplate
from langchain.vectorstores import Chroma
from langchain_google_genai import GoogleGenerativeAIEmbeddings
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain.document_loaders import DirectoryLoader, TextLoader
import pandas as pd
from langchain.schema import Document

# Configuration des clés API (à définir dans les variables d'environnement)
os.environ["GEMINI_API_KEY"] = "AIzaSyCsXwUjY9z2Jq4g7OhWhsLLkrC4UAB_SLs"

# Configuration du modèle d'embedding
embedding_model = GoogleGenerativeAIEmbeddings(
    model="models/embedding-001",
    google_api_key=os.environ["GEMINI_API_KEY"],
)

# Fonction pour charger les documents et créer la base de connaissances
def create_knowledge_base(directory_path="./documents"):
    # Vérifier si le répertoire de documents existe, sinon le créer
    if not os.path.exists(directory_path):
        os.makedirs(directory_path, exist_ok=True)
        print(f"Répertoire {directory_path} créé.")
        
        # Créer un document d'exemple pour éviter l'erreur de dossier vide
        with open(f"{directory_path}/exemple_gestion_evenements.txt", "w") as f:
            f.write("""
            # Guide de base pour la gestion d'événements
            
            ## Types d'événements courants
            - Conférences professionnelles
            - Séminaires d'entreprise
            - Lancements de produits
            - Mariages et célébrations
            - Festivals et concerts
            
            ## Étapes essentielles pour organiser un événement
            1. Définir les objectifs et le concept de l'événement
            2. Établir un budget prévisionnel
            3. Choisir une date et un lieu appropriés
            4. Planifier la logistique (équipement, restauration, etc.)
            5. Promouvoir l'événement
            6. Gérer les inscriptions ou la billetterie
            7. Coordonner le jour J
            8. Faire un bilan post-événement
            
            ## Conseils pour réussir un événement
            - Commencer la planification suffisamment tôt
            - Prévoir un plan B pour les imprévus
            - Déléguer les tâches efficacement
            - Communiquer clairement avec toutes les parties prenantes
            - Soigner l'accueil des participants
            """)
        print("Document d'exemple créé.")

    # Vérifier si la base de données vectorielle existe déjà
    if os.path.exists("./chroma_db") and os.listdir("./chroma_db"):
        try:
            print("Chargement de la base de données vectorielle existante...")
            vectorstore = Chroma(persist_directory="./chroma_db", embedding_function=embedding_model)
            return vectorstore
        except Exception as e:
            print(f"Erreur lors du chargement de la base vectorielle existante: {e}")
            # Si échec, essayer de recréer la base
            os.rename("./chroma_db", f"./chroma_db_backup_{int(time.time())}")
            print("Ancienne base renommée. Tentative de création d'une nouvelle base...")
    
    # Charger les documents depuis le répertoire spécifié
    try:
        # Vérifier s'il y a des fichiers .txt dans le répertoire
        if not any(f.endswith('.txt') for f in os.listdir(directory_path) if os.path.isfile(os.path.join(directory_path, f))):
            print("Aucun fichier .txt trouvé dans le répertoire. Création d'un document par défaut...")
            with open(f"{directory_path}/exemple_gestion_evenements.txt", "w") as f:
                f.write("""
                # Guide de base pour la gestion d'événements
                
                ## Types d'événements courants
                - Conférences professionnelles
                - Séminaires d'entreprise
                - Lancements de produits
                - Mariages et célébrations
                - Festivals et concerts
                
                ## Étapes essentielles pour organiser un événement
                1. Définir les objectifs et le concept de l'événement
                2. Établir un budget prévisionnel
                3. Choisir une date et un lieu appropriés
                4. Planifier la logistique (équipement, restauration, etc.)
                5. Promouvoir l'événement
                6. Gérer les inscriptions ou la billetterie
                7. Coordonner le jour J
                8. Faire un bilan post-événement
                
                ## Conseils pour réussir un événement
                - Commencer la planification suffisamment tôt
                - Prévoir un plan B pour les imprévus
                - Déléguer les tâches efficacement
                - Communiquer clairement avec toutes les parties prenantes
                - Soigner l'accueil des participants
                """)
                
        loader = DirectoryLoader(directory_path, glob="**/*.txt", loader_cls=TextLoader)
        documents = loader.load()
        print(f"{len(documents)} documents chargés.")
        
        if not documents:
            print("Aucun document n'a pu être chargé. Création d'une base de connaissances vide.")
            # Créer une base vide avec un document fictif minimal
            from langchain.schema import Document
            documents = [Document(page_content="Information sur la gestion d'événements.", metadata={"source": "default"})]
        
        # Diviser les documents en chunks
        text_splitter = RecursiveCharacterTextSplitter(chunk_size=1000, chunk_overlap=100)
        chunks = text_splitter.split_documents(documents)
        print(f"{len(chunks)} chunks créés.")
        
        # Créer et persister la base de données vectorielle
        vectorstore = Chroma.from_documents(
            documents=chunks, 
            embedding=embedding_model,
            persist_directory="./chroma_db"
        )
        vectorstore.persist()
        print("Base de données vectorielle créée et persistée.")
        return vectorstore
    except Exception as e:
        print(f"Erreur lors de la création de la base de connaissances: {e}")
        # Créer une base minimale pour que l'application fonctionne
        try:
            from langchain.schema import Document
            # Créer un document factice minimal
            fallback_doc = Document(
                page_content="Informations basiques sur la gestion d'événements. Veuillez ajouter des documents pour améliorer les réponses.",
                metadata={"source": "fallback"}
            )
            # Créer une base avec ce document
            vectorstore = Chroma.from_documents(
                documents=[fallback_doc],
                embedding=embedding_model,
                persist_directory="./chroma_db"
            )
            vectorstore.persist()
            print("Base de données vectorielle minimale créée.")
            return vectorstore
        except Exception as e2:
            print(f"Échec de la création de la base de secours: {e2}")
            return None

# Créer le modèle Gemini Pro pour la génération de texte
try:
    llm = ChatGoogleGenerativeAI(model="gemini-2.0-flash", google_api_key=os.environ["GEMINI_API_KEY"])
except Exception as e:
    print(f"Erreur lors de l'initialisation du modèle LLM: {e}")
    # Définir un LLM minimal pour éviter l'erreur (sera géré par la logique du chatbot)
    llm = None

# Créer la base de connaissances
try:
    vectorstore = create_knowledge_base()
except Exception as e:
    print(f"Erreur lors de la création de la base de connaissances: {e}")
    vectorstore = None

# Template pour le prompt du RAG
event_expert_template = """
Tu es un assistant professionnel spécialisé dans la création et la gestion d'événements. 
Tu dois aider les utilisateurs à planifier, organiser et gérer leurs événements de manière efficace.

Voici le contexte basé sur des documents pertinents :
{context}

Question de l'utilisateur : {question}

Réponds de manière professionnelle, claire et structurée. Si la réponse ne se trouve pas dans le contexte fourni,
indique poliment que tu ne disposes pas de cette information spécifique et suggère à l'utilisateur de reformuler sa question
ou de consulter un professionnel pour obtenir des conseils personnalisés.

Ta réponse doit être complète et contenir des étapes concrètes si nécessaire. N'invente pas d'informations qui ne seraient pas
dans le contexte fourni.
"""

event_expert_prompt = PromptTemplate(
    input_variables=["context", "question"],
    template=event_expert_template,
)

# Fonction qui utilise ChromaDB pour la recherche et Gemini Pro pour générer une réponse
def event_management_chatbot(question):
    global vectorstore
    
    # Si la base de connaissances n'est pas disponible, essayer de la créer
    if vectorstore is None:
        print("Tentative de création de la base de connaissances...")
        vectorstore = create_knowledge_base()
        
        # Si toujours pas disponible après tentative
        if vectorstore is None:
            # Répondre directement sans RAG
            try:
                fallback_prompt = """
                Tu es un assistant professionnel spécialisé dans la création et la gestion d'événements.
                Réponds à cette question de manière concise mais informative, en te basant sur tes connaissances générales:
                
                Question: {question}
                
                Ta réponse doit être professionnelle et utile, même si tu n'as pas accès à une base de connaissances spécifique.
                """
                formatted_fallback = fallback_prompt.replace("{question}", question)
                response = llm.invoke(formatted_fallback)
                return response.content + "\n\n(Note: La base de connaissances n'est pas disponible. Cette réponse est basée sur des connaissances générales.)"
            except Exception as e:
                return f"Désolé, je ne peux pas répondre à cette question pour le moment. Erreur: {str(e)}"
    
    try:
        # Recherche des documents pertinents dans la base de données Chroma
        retrieved_docs = vectorstore.similarity_search(question, k=3)
        context = "\n".join([doc.page_content for doc in retrieved_docs])
        
        # Créer le prompt avec le contexte et la question
        formatted_prompt = event_expert_prompt.format(context=context, question=question)
        
        # Utiliser le modèle pour générer la réponse
        response = llm.invoke(formatted_prompt)
        
        return response.content
    except Exception as e:
        # En cas d'erreur avec la base vectorielle, essayer une réponse directe
        try:
            print(f"Erreur avec la recherche vectorielle: {e}. Tentative de réponse directe...")
            fallback_prompt = """
            Tu es un assistant professionnel spécialisé dans la création et la gestion d'événements.
            Réponds à cette question de manière concise mais informative, en te basant sur tes connaissances générales:
            
            Question: {question}
            
            Ta réponse doit être professionnelle et utile, même si tu n'as pas accès à une base de connaissances spécifique.
            """
            formatted_fallback = fallback_prompt.replace("{question}", question)
            response = llm.invoke(formatted_fallback)
            return response.content + "\n\n(Note: Erreur d'accès à la base de connaissances. Cette réponse est basée sur des connaissances générales.)"
        except Exception as e2:
            return f"Désolé, une erreur s'est produite lors du traitement de votre question: {str(e)}. Erreur secondaire: {str(e2)}"

# Fonction pour ajouter un nouvel événement à la base de données
def add_event_to_database(event_name, event_date, event_description, event_location, event_capacity):
    try:
        # Structure simple pour stocker les événements (dans un vrai cas, utilisez une base de données)
        events_file = "events_database.csv"
        
        # Créer un nouveau DataFrame avec les informations de l'événement
        new_event = pd.DataFrame({
            'Nom': [event_name],
            'Date': [event_date],
            'Description': [event_description],
            'Lieu': [event_location],
            'Capacité': [event_capacity]
        })
        
        # Vérifier si le fichier existe déjà
        if os.path.exists(events_file):
            # Lire les événements existants et ajouter le nouveau
            events_df = pd.read_csv(events_file)
            events_df = pd.concat([events_df, new_event], ignore_index=True)
        else:
            events_df = new_event
        
        # Sauvegarder le DataFrame mis à jour dans le fichier CSV
        events_df.to_csv(events_file, index=False)
        
        # Créer un document texte pour cet événement pour le RAG
        event_doc = f"""
        Nom de l'événement: {event_name}
        Date: {event_date}
        Description: {event_description}
        Lieu: {event_location}
        Capacité: {event_capacity}
        """
        
        # Sauvegarder le document dans le dossier des documents
        os.makedirs("./documents/events", exist_ok=True)
        with open(f"./documents/events/{event_name.replace(' ', '_')}.txt", "w") as f:
            f.write(event_doc)
        
        # Mettre à jour la base de connaissances vectorielle
        global vectorstore
        vectorstore = create_knowledge_base()
        
        return f"Événement '{event_name}' ajouté avec succès à la base de données!"
    except Exception as e:
        return f"Erreur lors de l'ajout de l'événement: {str(e)}"

# Fonction pour lister tous les événements
def list_all_events():
    try:
        events_file = "events_database.csv"
        if not os.path.exists(events_file):
            return "Aucun événement n'a encore été enregistré."
        
        events_df = pd.read_csv(events_file)
        if events_df.empty:
            return "Aucun événement n'a encore été enregistré."
        
        result = "Liste des événements:\n\n"
        for index, row in events_df.iterrows():
            result += f"Nom: {row['Nom']}\n"
            result += f"Date: {row['Date']}\n"
            result += f"Lieu: {row['Lieu']}\n"
            result += f"Capacité: {row['Capacité']}\n"
            result += f"Description: {row['Description']}\n\n"
            result += "-" * 50 + "\n\n"
        
        return result
    except Exception as e:
        return f"Erreur lors de la récupération des événements: {str(e)}"

# Interface Gradio pour le chatbot avec plusieurs onglets
with gr.Blocks(title="Assistant de Gestion d'Événements") as interface:
    gr.Markdown("# 📅 Assistant Professionnel de Gestion d'Événements")
    gr.Markdown("""Cet assistant vous aide à créer et gérer vos événements. 
                Posez des questions sur l'organisation d'événements ou utilisez les fonctionnalités pour ajouter et consulter vos événements.""")
    
    with gr.Tabs():
        with gr.Tab("Poser une Question"):
            with gr.Row():
                with gr.Column():
                    question_input = gr.Textbox(label="Posez une question sur la gestion d'événements", lines=3)
                    question_button = gr.Button("Envoyer", variant="primary")
                    
                    # Exemples de questions
                    gr.Examples(
                        examples=[
                            "Comment organiser un événement d'entreprise?",
                            "Quelles sont les étapes pour planifier une conférence?",
                            "Comment estimer le budget pour un mariage?",
                            "Quels sont les meilleurs outils pour gérer les inscriptions à un événement?",
                            "Comment promouvoir un événement sur les réseaux sociaux?"
                        ],
                        inputs=question_input
                    )
                
                with gr.Column():
                    answer_output = gr.Textbox(label="Réponse", lines=10)
        
        with gr.Tab("Ajouter un Événement"):
            with gr.Column():
                event_name = gr.Textbox(label="Nom de l'événement")
                event_date = gr.Textbox(label="Date (JJ/MM/AAAA)")
                event_location = gr.Textbox(label="Lieu")
                event_capacity = gr.Number(label="Capacité (nombre de personnes)", value=50)
                event_description = gr.Textbox(label="Description", lines=5)
                add_event_button = gr.Button("Ajouter l'événement", variant="primary")
                add_event_result = gr.Textbox(label="Résultat", lines=2)
        
        with gr.Tab("Liste des Événements"):
            with gr.Column():
                refresh_button = gr.Button("Rafraîchir la liste")
                events_list = gr.Textbox(label="Événements enregistrés", lines=15)
    
    # Connecter les composants aux fonctions
    question_button.click(
        fn=event_management_chatbot,
        inputs=question_input,
        outputs=answer_output
    )
    
    add_event_button.click(
        fn=add_event_to_database,
        inputs=[event_name, event_date, event_description, event_location, event_capacity],
        outputs=add_event_result
    )
    
    refresh_button.click(
        fn=list_all_events,
        inputs=[],
        outputs=events_list
    )

# Fonction pour vérifier l'état du système et initialiser si nécessaire
def check_system_status():
    global llm, vectorstore
    status_messages = []
    all_ok = True
    
    # Vérifier la clé API
    if "GEMINI_API_KEY" not in os.environ or not os.environ["GEMINI_API_KEY"]:
        status_messages.append("⚠️ Clé API Gemini non configurée dans les variables d'environnement.")
        all_ok = False
    else:
        status_messages.append("✅ Clé API Gemini configurée.")
    
    # Vérifier le modèle LLM
    if llm is None:
        try:
            llm = ChatGoogleGenerativeAI(model="gemini-2.0-flash", google_api_key=os.environ.get("GEMINI_API_KEY", "clé_temporaire"))
            status_messages.append("✅ Modèle LLM initialisé.")
        except Exception as e:
            status_messages.append(f"⚠️ Erreur lors de l'initialisation du modèle LLM: {str(e)}")
            all_ok = False
    else:
        status_messages.append("✅ Modèle LLM déjà initialisé.")
    
    # Vérifier la base de connaissances
    if vectorstore is None:
        try:
            vectorstore = create_knowledge_base()
            if vectorstore is not None:
                status_messages.append("✅ Base de connaissances créée avec succès.")
            else:
                status_messages.append("⚠️ Échec de la création de la base de connaissances.")
                all_ok = False
        except Exception as e:
            status_messages.append(f"⚠️ Erreur lors de la création de la base de connaissances: {str(e)}")
            all_ok = False
    else:
        status_messages.append("✅ Base de connaissances déjà initialisée.")
    
    # État du répertoire des documents
    docs_dir = "./documents"
    if not os.path.exists(docs_dir):
        os.makedirs(docs_dir, exist_ok=True)
        status_messages.append("✅ Répertoire des documents créé.")
    else:
        num_files = len([f for f in os.listdir(docs_dir) if os.path.isfile(os.path.join(docs_dir, f)) and f.endswith('.txt')])
        status_messages.append(f"✅ Répertoire des documents existant ({num_files} fichiers .txt).")
    
    # État du fichier de base de données des événements
    events_file = "events_database.csv"
    if os.path.exists(events_file):
        try:
            events_df = pd.read_csv(events_file)
            status_messages.append(f"✅ Base de données d'événements existante ({len(events_df)} événements enregistrés).")
        except Exception as e:
            status_messages.append(f"⚠️ Erreur lors de la lecture de la base de données d'événements: {str(e)}")
            all_ok = False
    else:
        status_messages.append("ℹ️ Aucune base de données d'événements existante.")
    
    overall_status = "✅ Système prêt!" if all_ok else "⚠️ Système partiellement opérationnel. Certaines fonctionnalités peuvent être limitées."
    return overall_status + "\n\n" + "\n".join(status_messages)

# Ajouter un onglet pour le statut du système
with interface:
    with gr.Tab("État du Système"):
        check_status_button = gr.Button("Vérifier l'état du système")
        system_status = gr.Textbox(label="État du système", lines=10)
        reinit_system_button = gr.Button("Réinitialiser le système")
        
        def reinitialize_system():
            global llm, vectorstore
            try:
                # Réinitialiser le LLM
                llm = ChatGoogleGenerativeAI(model="gemini-2.0-flash", google_api_key=os.environ.get("GEMINI_API_KEY", "clé_temporaire"))
                
                # Recréer la base de connaissances
                if os.path.exists("./chroma_db"):
                    import shutil
                    backup_dir = f"./chroma_db_backup_{int(time.time())}"
                    shutil.move("./chroma_db", backup_dir)
                    print(f"Base existante sauvegardée dans {backup_dir}")
                
                vectorstore = create_knowledge_base()
                return "✅ Système réinitialisé avec succès. Vérifiez l'état du système pour plus de détails."
            except Exception as e:
                return f"❌ Erreur lors de la réinitialisation: {str(e)}"
        
        check_status_button.click(fn=check_system_status, inputs=[], outputs=system_status)
        reinit_system_button.click(fn=reinitialize_system, inputs=[], outputs=system_status)

# Lancer l'interface Gradio
if __name__ == "__main__":
    print("Préparation de l'assistant de gestion d'événements...")
    
    # Afficher le statut initial
    initial_status = check_system_status()
    print("\n" + initial_status + "\n")
    
    interface.launch(share=True)