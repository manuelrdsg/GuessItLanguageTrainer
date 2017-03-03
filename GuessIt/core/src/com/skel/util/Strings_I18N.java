package com.skel.util;

import java.util.ArrayList;

/**
 * Created by juanm on 07/03/2016.
 */
public class Strings_I18N {

    private String language;

    private String yesString, noString, saveNoteBookString, backString, statsString, backMenuString, rateWindowString, roundWindowString, newRoundString, hintString, answerString, guessString, chanceString, addDefString, selectLvString, selectCatString, enterWordString, enterArticleString, enterSentenceString, enterHintString, sendString, playString, statsDefString, statsSuccessString, statsAvgString, MPCategoryString, RepDefString;

    private String spaces = new String(" * ");
    private ArrayList<String> preguntas = new ArrayList<String>();
    public Strings_I18N(){

    }

    private void setQuestions(){
        if(language.equals("English")){
            preguntas.add(spaces + "El verbo está bien conjugado.");
            preguntas.add(spaces + "Los signos de puntuación están bien.");
            preguntas.add(spaces + "Pregunta 3");
            preguntas.add(spaces + "Pregunta 4");
        }else{
            if(language.equals("German")){
                preguntas.add(spaces + "Sind die Verben korrekt konjugiert?");
                preguntas.add(spaces + "Sind die Substantive groß geschrieben?");
                preguntas.add(spaces + "Sind die Verben an der korrekten Stelle?");
                preguntas.add(spaces + "Sind die Präpositionen korrekt?");
                preguntas.add(spaces + "Sind die Artikel der Substantive korrekt?");
            }else{
                if(language.equals("Spanish")){
                    preguntas.add(spaces + "¿El verbo está bien conjugado?");
                    preguntas.add(spaces + "¿Los signos de puntuación están bien?");
                    preguntas.add(spaces + "¿Las preposiciones son correctas?");
                    preguntas.add(spaces + "¿Se encuentra el verbo en el tiempo correcto?");
                }
            }
        }
    }

    private void setStrings(){
        if(language.equals("English")){
            backString = new String("Back");
            statsString = new String("Stats");
            statsDefString = new String("Definitions played");
            statsSuccessString = new String("Successes");
            statsAvgString = new String("Average Definitions Rating");
            MPCategoryString = new String("Most played category");
            RepDefString = new String("Reported definitions");
            selectLvString = new String("Select level:");
            selectCatString = new String("Select categories:");
            enterWordString = new String("Enter word:");
            enterArticleString = new String("Enter article:");
            enterSentenceString = new String("Enter sentence:");
            enterHintString = new String("Enter hint:");
            sendString = new String("Send!");
            playString = new String("Play!");
            hintString = new String("Hint");
            addDefString = new String("Add a definition!");
            chanceString = new String("Chances:");
            guessString = new String("Guess");
            answerString = new String("Answer:");
            newRoundString = new String("New Round!");
            backMenuString = new String("Back to menu");
            rateWindowString = new String("Rate this definition");
            roundWindowString = new String("Round stats");
            saveNoteBookString = new String("Save");
            yesString = new String("Yes");
            noString = new String("No");

            setQuestions();
        }else{
            if(language.equals("German")){
                backString = new String("Zurück");
                statsString = new String("Statistiken");
                statsDefString = new String("Gespielte Definitionen");
                statsSuccessString = new String("Erfolge");
                statsAvgString = new String("Evaluierung der Definitionen");
                MPCategoryString = new String("Meist gespielte Kategorie");
                RepDefString = new String("Definitionen mit Fehlern");
                selectLvString = new String("Wähl das Niveau:");
                selectCatString = new String("Wähl die Kategorie:");
                enterWordString = new String("Notier das Wort:");
                enterArticleString = new String("Notier den Artikel:");
                enterSentenceString = new String("Notier den Satz:");
                enterHintString = new String("Gib einen Tipp:");
                sendString = new String("Senden");
                playString = new String("Spiel!");
                hintString = new String("Tipp");
                addDefString = new String("Schreib eine Definition!");
                chanceString = new String("Versuche:");
                guessString = new String("Rate!");
                answerString = new String("Antwort:");
                newRoundString = new String("Neue Spielrunde!");
                backMenuString = new String("Zurück zum Menu");
                rateWindowString = new String("Evaluier die Definition!");
                roundWindowString = new String("Spielrunde");
                saveNoteBookString = new String("Speichern");
                yesString = new String("Ja");
                noString = new String("Nein");

                setQuestions();
            }else{
                if(language.equals("Spanish")){
                    backString = new String("Atrás");
                    statsString = new String("Estadísticas");
                    statsDefString = new String("Definiciones jugadas");
                    statsSuccessString = new String("Aciertos");
                    statsAvgString = new String("Puntuación media");
                    MPCategoryString = new String("Categoría más jugada");
                    RepDefString = new String("Definiciones reportadas");
                    selectLvString = new String("Selecciona nivel:");
                    selectCatString = new String("Selecciona categorías:");
                    enterWordString = new String("Introduce palabra:");
                    enterArticleString = new String("Introduce el artículo:");
                    enterSentenceString = new String("Introduce la frase:");
                    enterHintString = new String("Introduce la pista:");
                    sendString = new String("Enviar!");
                    playString = new String("Jugar!");
                    hintString = new String("Pista");
                    addDefString = new String("Añade una definición!");
                    chanceString = new String("Intentos:");
                    guessString = new String("Adivinar");
                    answerString = new String("Respuesta:");
                    newRoundString = new String("Nueva ronda!");
                    backMenuString = new String("Volver al menú");
                    rateWindowString = new String("Puntúa ésta definición");
                    roundWindowString = new String("Puntuación de la ronda");
                    saveNoteBookString = new String("Guardar");
                    yesString = new String("Sí");
                    noString = new String("No");

                    setQuestions();
                }
            }
        }
    }

    public ArrayList<String> getQuestions(){
        return preguntas;
    }

    public String yes(){ return yesString; }

    public String no() { return noString; }

    public String save(){ return saveNoteBookString; }

    public String back(){
        return backString;
    }

    public String send(){
        return sendString;
    }

    public String rate(){
        return rateWindowString;
    }

    public String round(){
        return roundWindowString;
    }

    public String newRound(){
        return newRoundString;
    }

    public String backMenu(){
        return backMenuString;
    }

    public String hint(){
        return hintString;
    }

    public String chances(){
        return chanceString;
    }

    public String guess(){
        return guessString;
    }

    public String answer(){
        return answerString;
    }

    public String play(){
        return playString;
    }

    public String addDef(){
        return addDefString;
    }

    public String stats(){
        return statsString;
    }

    public String defPlayed(){
        return statsDefString;
    }

    public String sucPlayed(){
        return statsSuccessString;
    }

    public String avgRated(){
        return statsAvgString;
    }

    public String mostCategory(){
        return MPCategoryString;
    }

    public String reportedDef(){
        return RepDefString;
    }

    public String selLevel(){
        return selectLvString;
    }

    public String selCategory(){
        return selectCatString;
    }

    public String enterWord(){
        return enterWordString;
    }

    public String enterArticle(){
        return enterArticleString;
    }

    public String enterSentence(){
        return enterSentenceString;
    }

    public String enterHint(){
        return enterHintString;
    }

    public Strings_I18N(String language){
        this.language = language;
        setStrings();
    }


}
