package com.skel.util;

import java.util.ArrayList;

/**
 * Created by juanm on 25/02/2016.
 */
public class GEngine {
    private ArrayList<Definition> engine_definitions;
    private ArrayList<Boolean> engine_results;
    private int current_def;
    private int max_def;

    public GEngine(){

    }

    public void setDefinitions(ArrayList<Definition> def){
        engine_definitions = def;
        current_def = 0;
        max_def = engine_definitions.size();
        engine_results = new ArrayList<Boolean>(max_def);
        for(int i=0;i<max_def;i++)
            engine_results.add(i,true);
    }

    public String getPhrase(){
        // Hacer la transformacion de "Palabra" por "********"
        return engine_definitions.get(current_def).getFrase().replaceFirst("\\b"+engine_definitions.get(current_def).getPalabra()+"\\b","*****");
    }

    public String getPassPhrase(){
        return "[BLACK]"+engine_definitions.get(current_def).getFrase().replaceFirst("\\b"+engine_definitions.get(current_def).getPalabra()+"\\b", "[OLIVE]"+engine_definitions.get(current_def).getPalabra()+"[BLACK]");
    }

    public String getWrongPhrase(){
        return "[BLACK]"+engine_definitions.get(current_def).getFrase().replaceFirst("\\b"+engine_definitions.get(current_def).getPalabra()+"\\b", "[RED]"+engine_definitions.get(current_def).getPalabra()+"[BLACK]");
    }

    public String getResultPhrase(){
        return engine_definitions.get(current_def).getFrase();
    }

    public String getResultPoints(){
        int countAcierto = 0;
        for(int i=0;i<engine_results.size();++i){
            if(engine_results.get(i)){
                countAcierto++;
            }
        }
        return String.valueOf(countAcierto)+" / "+String.valueOf(engine_results.size());
    }

    public String getHint(){
        return engine_definitions.get(current_def).getPista();
    }

    public String getArticle() {return engine_definitions.get(current_def).getArticulo(); }

    public boolean endRound(){
        return current_def==max_def;
    }

    public void nextDefinition(){
            current_def++;
    }

    public boolean compare(String answer){
        if(engine_definitions.get(current_def).getPalabra().equals(answer)){
            engine_results.set(current_def,true);
            return true;
        }else{
            engine_results.set(current_def,false);
            return false;
        }
    }

    public Definition getDefinition(){
        return engine_definitions.get(current_def);
    }

}
